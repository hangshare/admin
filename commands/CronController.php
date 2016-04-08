<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\commands\Yii;
use yii\db\Query;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CronController extends Controller {

    public function actionIndex() {
        echo 'index';
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionDeservedamount() {
        \Yii::$app->db->createCommand("UPDATE `user_stats` SET `cantake_amount` = `cantake_amount`+`available_amount`,`available_amount`=0 WHERE `available_amount` >= 100")->execute();

        \Yii::$app->db->createCommand("UPDATE user_stats as t
LEFT JOIN user as user on (user.id = t.userId)
SET cantake_amount = cantake_amount +available_amount, available_amount=0
WHERE (available_amount >= 50 OR cantake_amount != 0) AND `user`.`plan` = 1")->execute();
    }

}
