<?php
// Połączenie z bazą danych
$db_host = 'localhost';
$db_user = 'username';
$db_pass = 'password';
$db_name = 'notes';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$conn) {
    die('Nie udało się połączyć z bazą danych: ' . mysqli_connect_error());
}

// Dodawanie notatki
if (isset($_POST['note'])) {
    $note = $_POST['note'];
    $query = "INSERT INTO notes (note) VALUES ('$note')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo 'Notatka została dodana.';
    } else {
        echo 'Wystąpił błąd przy dodawaniu notatki.';
    }
}

// Edycja notatki
if (isset($_POST['edit_note'])) {
    $note_id = $_POST['note_id'];
    $note_text = $_POST['note_text'];
    $query = "UPDATE notes SET note='$note_text' WHERE id=$note_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo 'Notatka została zaktualizowana.';
    } else {
        echo 'Wystąpił błąd przy aktualizacji notatki.';
    }
}

// Usuwanie notatki
if (isset($_POST['delete_note'])) {
    $note_id = $_POST['note_id'];
    $query = "DELETE FROM notes WHERE id=$note_id";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo 'Notatka została usunięta.';
    } else {
        echo 'Wystąpił błąd przy usuwaniu notatki.';
    }
}

// Wyświetlanie notatek
$query = "SELECT * FROM notes";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div>';
        echo '<p>' . $row['note'] . '</p>';
        echo '<form method="post">';
        echo '<input type="hidden" name="note_id" value="' . $row['id'] . '">';
        echo '<input type="hidden" name="note_text" value="' . $row['note'] . '">';
        echo '<input type="submit" name="edit_note" value="Edytuj">';
        echo '<input type="submit" name="delete_note" value="Usuń">';
        echo '</form>';
        echo '</div>';
    }
} else {
    echo 'Brak notatek.';
}

// Zamknięcie połączenia z bazą danych
mysqli_close($conn);
?>

<!-- Formularz dodawania notatki -->
<form method="post">
    <label for="note">Dodaj notatkę:</label><br>
    <textarea name="note"></textarea><br>
    <input type="submit" value="Dodaj">
</form>
