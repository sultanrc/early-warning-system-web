<!DOCTYPE html>
<html>

<head>
    <title>Judul Halaman</title>
</head>

<body>
    <form method="post" action="<?= base_url('/predict') ?>">
        <label for="suhu_luar_besok">Suhu luar besok:</label>
        <input type="text" name="suhu_luar_besok" id="suhu_luar_besok"><br><br>

        <label for="suhu_ac_besok">Suhu AC besok:</label>
        <input type="text" name="suhu_ac_besok" id="suhu_ac_besok"><br><br>

        <input type="submit" value="Submit">
    </form>

    <?php if (isset($output)): ?>
    <p>Hasil output dari skrip Python:</p>
    <p><?= $output ?></p>
    <?php endif; ?>
</body>

</html>