<?php

/** shows alerts and deletes */
function showAlerts()
{
    if (isset($_SESSION['danger_alerts'])) {
        if (count($_SESSION['danger_alerts'])) {
            foreach ($_SESSION['danger_alerts'] as $alert) {
                ?>
                <div class="alert alert-danger" role="alert"><?= $alert ?></div>
            <?php
                        }
                    }
                }

                if (isset($_SESSION['success_alerts'])) {
                    if (count($_SESSION['success_alerts'])) {
                        foreach ($_SESSION['success_alerts'] as $alert) {
                            ?>
                <div class="alert alert-success" role="alert"><?= $alert ?></div>
<?php
            }
        }
    }
}

function deleteAlerts()
{
    $_SESSION['danger_alerts'] = null;
    $_SESSION['success_alerts'] = null;
}
