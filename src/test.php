<!DOCTYPE html>
<html>
<head>
  <style>
    .content {
      display: none;
    }
  </style>
  <script>
    function toggleTable() {
      var content = document.getElementById('tableContent');
      content.style.display = (content.style.display === "none") ? "block" : "none";
    }
  </script>
</head>
<body>
  <button onclick="toggleTable()">Toggle Table</button>

  <?php
  // Sample data
  $tableData = [
    ['John Doe', 'johndoe@example.com', 'New York'],
    ['Jane Smith', 'janesmith@example.com', 'London'],
    ['Bob Johnson', 'bjohnson@example.com', 'Paris'],
  ];
  ?>

  <table id="tableContent">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>City</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($tableData as $row) {
        $name = $row[0];
        $email = $row[1];
        $city = $row[2];
        ?>
        <tr>
          <td><?php echo $name; ?></td>
          <td><?php echo $email; ?></td>
          <td><?php echo $city; ?></td>
        </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</body>
</html>
