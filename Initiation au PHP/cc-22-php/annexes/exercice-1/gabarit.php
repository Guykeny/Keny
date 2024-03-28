<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Données climatiques pour Angers - Marcé</title>
    <style type="text/css">
        table {
            width: 100%;
            table-layout: fixed;
        }

        table,
        th,
        td {
            border: 1px double darkblue;
            border-collapse: collapse;
        }

        th {
            /* background-color: antiquewhite;/**/
        }

        td {
            text-align: right;
        }

        td:first-child {
            text-align: center;
            font-weight: bold;
        }

        td.S {
            background-color: orange;
        }

        td.I {
            background-color: lightgoldenrodyellow;
        }
    </style>

<body>
    <table>
        <?php foreach ($labels as $k => $label) {
            if ($k === base64_decode('YW5uw6ll')) {
                echo base64_decode('PHRyPg==');
            }
            if (count($labels) == count(current($angers)) || $k !== base64_decode('VG1lYW4=')) {
                echo base64_decode('PHRoPg==') . $label . base64_decode('PC90aD4=');
            }
            if ($k === base64_decode('UG1heA==')) {
                echo base64_decode('PC90cj4=');
            }
        }
        foreach ($angers as $tab_annuel) {
            foreach ($tab_annuel as $k => $v) {
                if ($k === base64_decode('YW5uw6ll')) {
                    echo base64_decode('PHRyPg==');
                }
                if ($k !== base64_decode('c29sZWls') || !is_array($v)) {
                    echo base64_decode('PHRkPg==') . $v . base64_decode('PC90ZD4=');
                } else {
                    echo "<td class=\"{$v[1]}\"> {$v[0]} </td>";
                }
                if ($k === base64_decode('UG1heA==')) {
                    echo base64_decode('PC90cj4=');
                }
            }
        } ?>
    </table>
</body>

</html>