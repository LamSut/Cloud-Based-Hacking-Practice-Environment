<?php
require_once "../../login/config.php";

// Number of comments to load per request
$limit = 6;

// Get the offset (number of comments to skip based on current page)
$offset = isset($_POST['offset']) ? (int)$_POST['offset'] : 0;

// Build the query
$sql = "SELECT cmt.idcmt, cmt.content, cmt.time, acc.idacc AS id, acc.name AS name
        FROM cmt INNER JOIN acc ON cmt.idacc = acc.idacc ORDER BY cmt.idcmt DESC
        LIMIT $limit OFFSET $offset";

// Execute the query
$result = mysqli_query($db, $sql);
if (!$result) {
  die("Error: " . mysqli_error($db));
}

// Check if there are any comments
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='comment'>";
    echo "  <p>From <b>" . $row['id'] . " - " . $row['name'] . "</b> (" . $row['time'] . ")</p>";
    echo "  <p><i>" . $row['content'] . "</i></p>";
    echo "</div>";
  }

}

mysqli_close($db);

?> 