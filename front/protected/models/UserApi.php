<?php
/**
 * Raw User Api Model
 */

class UserApi
{
    const FREE = 0;
    const ONE = 1;
    const STAR = 2;

    /**
     * Get artist list
     * @param int $user_id
     * @param string $plan
     * @return bool|mixed
     */
    public static function upgrade($user_id, $plan)
    {
        // Check required
        if (!$plan) {
            return false;
        }

        // Update and return result
        return Yii::app()->db->createCommand("
            UPDATE user
            SET plan = " . self::getPlanFromString($plan) . ",
              plan_activated = NOW()
            WHERE id = " . $user_id . ";
        ")->execute();
    }

    public static function getPlanName($plan)
    {
        switch ($plan) {
            case self::ONE:
                return 'PromoOne';
            case self::STAR:
                return 'PromoStar';
            default:
                return 'Demo';
        }
    }

    public static function getPlanFromString($plan)
    {
        switch ($plan) {
            case 'one':
                return self::ONE;
            case 'star':
                return self::STAR;
            default:
                return self::FREE;
        }
    }

    public static function switchRole()
    {
        if ($user = User::getLogged()) {
            $user->role = $user->role == User::ROLE_PROMOTER ? User::ROLE_ARTIST : User::ROLE_PROMOTER;
            if ($user->save()) {
                return $user->getNormalizedData(true, true);
            }
        }
        return false;
    }
}