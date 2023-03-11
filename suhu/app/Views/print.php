<!DOCTYPE html>
<html>
<head>
	<title>PetroChina International Jabung</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background-color: #f7f7f7;
			font-family: Arial, sans-serif;
			font-size: 16px;
			line-height: 1.5;
		}

		header {
			background-color: #333;
			color: #fff;
			text-align: center;
			padding: 20px;
            
		}

		footer {
			background-color: #333;
			color: #fff;
			text-align: center;
			padding: 20px;
			position: absolute;
			bottom: 0;
			width: 100%;
		}

        table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1em;
        margin_top: 1em;
        }

        th {
        background-color: #333;
        color: #fff;
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

        .logo {
			display: inline-block;
			vertical-align: middle;
			margin: 0 10px;
			max-height: 50px;
		}

		.logo-left {
			float: left;
		}

		.logo-right {
			float: right;
            imag 
		}
        .logo-container {
            display: inline-block;
            vertical-align: middle;
            width: 50%;
            text-align: center;
        }
	</style>
</head>
<body>
<header>
	<img class="logo logo-left" src="assets/images/logo.png" alt=" ">
	<h1>PetroChina International Jabung</h1>
	<img class="logo logo-right" src="assets/images/logo.png" alt= "">
</header>
    <div class="container">
        <div class="col">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Temperature</th>
                            <th>Humidity</th>
                            <th>Fire anomaly</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ews as $value): ?>
                        <tr>
                            <td><?php echo $value['date'] ?></td>
                            <td><?php echo $value['time'] ?></td>
                            <td><?php echo $value['temp'] ?> °C</td>
                            <td><?php echo $value['hum'] ?> %</td>
                            <td><?php echo $value['fa'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

	<footer>
		<p>JI. Ahmad Yani RT. 19 RW. 04 Kcl. Pandan Jaya, Kee. Gcragai Kab. Tanjung .labung Timur - 36764 - Jambi<br>
			Phone: (0741) 570488/570353, Fax: (0741) 57021I</p>
	</footer>
</body>
</html>
