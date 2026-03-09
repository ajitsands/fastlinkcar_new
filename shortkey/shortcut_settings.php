<?php
session_start();
include "db.php";
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM shortcut_actions";
$result = $conn->query($sql);
?>

<h2>Shortcut Settings</h2>

<form id="shortcutForm">
<table border="1" cellpadding="10">
<tr>
    <th>Action</th>
    <th>Shortcut Key</th>
</tr>

<?php while ($row = $result->fetch_assoc()) { ?>
<tr>
    <td><?php echo $row['description']; ?></td>
    <td>
        <input 
            type="text" 
            class="shortcut-input"
            name="<?php echo $row['action_name']; ?>"
            value="<?php echo $row['default_key']; ?>"
        >
    </td>
</tr>
<?php } ?>

</table>
<br>
<button type="submit">Save Shortcuts</button>
</form>
<script>
document.querySelectorAll(".shortcut-input").forEach(input => {
    input.addEventListener("keydown", function (e) {
        e.preventDefault();

        let key = "";
        if (e.ctrlKey) key += "Ctrl+";
        if (e.altKey) key += "Alt+";
        if (e.shiftKey) key += "Shift+";

        key += e.key.toUpperCase();
        this.value = key;
    });
});

document.getElementById("shortcutForm").addEventListener("submit", function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("save_shortcuts.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(msg => alert("Shortcuts saved"));
});
</script>
