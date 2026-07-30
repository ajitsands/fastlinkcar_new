<?php
$db = new ClassDatabaseConnection();
$pdo = $db->pdo;

// Get categories
$stmt = $pdo->query("
    SELECT category_id, category_name, category_image 
    FROM view_vehicle_model 
    WHERE category_status = 'Active' 
    GROUP BY category_id, category_name, category_image
    ORDER BY category_id ASC
");

$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<ul class="list-group">';

foreach ($categories as $category) {

    // Get brands
    $stmt2 = $pdo->prepare("
        SELECT brand_id, brand_name
        FROM view_vehicle_model 
        WHERE category_id = ?
        GROUP BY brand_id, brand_name 
        ORDER BY brand_id
    ");
    $stmt2->execute([$category['category_id']]);
    $brands = $stmt2->fetchAll(PDO::FETCH_ASSOC);

    echo '
    <li class="list-group-item" data-category="'.$category['category_id'].'">
      <div class="d-flex align-items-center">
        <div class="avatar avatar-md me-2">
          <img src="httpdocs/images/vehicle_category_images/'.$category['category_image'].'" class="rounded-circle">
        </div>
        <span class="fw-bold">'.$category['category_name'].'</span>
      </div>

      <ul class="list-group mt-2 ms-4">';

    foreach ($brands as $b) {
        echo '
        <li style="cursor:pointer" class="list-group-item d-flex justify-content-between align-items-center" 
            data-brand="'.$b['brand_id'].'">
            '.$b['brand_name'].'</li>';
    }

    echo '</ul></li>';
}

echo '</ul>';
?>