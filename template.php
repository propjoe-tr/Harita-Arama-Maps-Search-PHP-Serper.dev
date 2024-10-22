<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detaylı Yer Arama Formu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
        body { 
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 9999 !important;
        }
        .result-card {
            transition: all 0.3s ease;
        }
        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 form-container">
                <h2 class="text-center mb-4">Detaylı Yer Arama</h2>
                <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Aranacak İsim:</label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="Örn: Restoran, Kafe, Otel" value="<?php echo htmlspecialchars($name ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="city" class="form-label">Şehir:</label>
                        <input type="text" class="form-control" id="city" name="city" required placeholder="Örn: İstanbul, Ankara, İzmir" value="<?php echo htmlspecialchars($city ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Ülke:</label>
                        <select class="form-select" id="country" name="country">
                            <option value="tr" <?php echo ($country ?? '') === 'tr' ? 'selected' : ''; ?>>Türkiye</option>
                            <option value="us" <?php echo ($country ?? '') === 'us' ? 'selected' : ''; ?>>Amerika Birleşik Devletleri</option>
                            <option value="gb" <?php echo ($country ?? '') === 'gb' ? 'selected' : ''; ?>>Birleşik Krallık</option>
                            <option value="de" <?php echo ($country ?? '') === 'de' ? 'selected' : ''; ?>>Almanya</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="language" class="form-label">Dil:</label>
                        <select class="form-select" id="language" name="language">
                            <option value="tr" <?php echo ($language ?? '') === 'tr' ? 'selected' : ''; ?>>Türkçe</option>
                            <option value="en" <?php echo ($language ?? '') === 'en' ? 'selected' : ''; ?>>İngilizce</option>
                            <option value="de" <?php echo ($language ?? '') === 'de' ? 'selected' : ''; ?>>Almanca</option>
                        </select>
                    </div>
    <div class="mb-3">
    <label for="limit" class="form-label">Gösterilecek Sonuç Sayısı (1-100):</label>
    <input type="number" class="form-control" id="limit" name="limit" value="<?php echo $limit ?? $config['results_per_page']; ?>" min="1" max="100">
</div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Ara</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="row mt-4">
                <div class="col-md-8 mx-auto">
                    <?php echo format_errors($error); ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($results) && is_array($results)): ?>
            <div class="row mt-4">
                <div class="col-md-8 mx-auto">
                    <h3 class="text-center mb-4">Arama Sonuçları</h3>
                    <?php echo format_search_results($results); ?>

                    <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
                        <?php echo generate_pagination_links($pagination['current_page'], $pagination['total_pages'], [
                            'name' => $name,
                            'city' => $city,
                            'country' => $country,
                            'language' => $language,
                            'limit' => $limit
                        ]); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($pagination)): ?>
            <div class="row mt-3">
                <div class="col-md-8 mx-auto">
                    <p class="text-center">
                        Toplam Sonuç: <?php echo $pagination['total_results']; ?>, 
                        Sayfa: <?php echo $pagination['current_page']; ?> / <?php echo $pagination['total_pages']; ?>,
                        Sayfa Başına Sonuç: <?php echo $pagination['results_per_page']; ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($api_response_time)): ?>
            <div class="row mt-4">
                <div class="col-md-8 mx-auto">
                    <p class="text-muted text-center">API Yanıt Süresi: <?php echo $api_response_time; ?> saniye</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    $(function() {
        function setupAutocomplete(inputId, type) {
            $("#" + inputId).autocomplete({
                source: function(request, response) {
                    $.getJSON("<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>", {
                        term: request.term,
                        type: type
                    }, response);
                },
                minLength: 2,
                select: function(event, ui) {
                    console.log("Selected: " + ui.item.value);
                }
            });
        }

        setupAutocomplete("name", "name");
        setupAutocomplete("city", "city");
    });
    </script>
</body>
</html>