<!DOCTYPE html>
<html>
<head>
	<title>Print View</title>
	<style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            line-height: 1.5;
        }

        .address {
            font-family: 'Open Sans', sans-serif;
            font-weight: 150;
            font-size: 11px;
        }
        .container {
            margin: 0 auto;
            max-width: 800px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1em;
            margin-top: 1em;
        }

        th {
            background-color: #fff;
            color: #000;
            text-align: left;
            padding: 0.5em;
        }

        td {
            border: 1px solid #ccc;
            padding: 0.5em;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-responsive {
            overflow-x: auto;
        }
        
        h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        hr {
            border: none;
            height: 1px;
            background-color: #ccc;
            margin-top: 5px;
            margin-bottom: 5px;
        }

        form {
            display: inline-block;
            margin-right: 10px;
        }

        label {
            display: inline-block;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <tr>
                            <th colspan="5" style="text-align: center;">
                                <div style="text-align: center;">
                                    <div style="font-size: 13px; text-align:left;">Date: <?php echo $date; ?></div>
                                    <hr>
                                    <div style="font-size: 17px;">Early Warning System Report</div>
                                    <hr>
                                    <div style="font-size: 12px;">PetroChina International Jabung Ltd</div>
                                    <div class="address">JI. Ahmad Yani RT. 19 RW. 04 Kel. Pandan Jaya</div>
                                    <div class="address">Kec. Geragai Kab. Tanjung Jabung Timur - 36764 - Jambi</div>
                                    <div class="address" style="margin-bottom:10px;">Phone: (0741) 570488/570353, Fax: (0741) 570211</div>
                                    <hr>
                                </div>
                            </th>
                        </tr>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Temperature</th>
                            <th>Humidity</th>
                            <th>Fire anomaly</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ews as $row) : ?>
                            <tr>
                                <td><?= esc($row->date) ?></td>
                                <td><?= esc($row->time) ?></td>
                                <td><?= esc($row->temp) ?></td>
                                <td><?= esc($row->hum) ?></td>
                                <td><?= esc($row->fa) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
