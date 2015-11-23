<?php
/**
 * Created by PhpStorm.
 * User: jhaskell
 * Date: 11/14/15
 * Time: 2:53 PM
 */

$files = glob(__DIR__ . "/app/data/old_pack/sagf_autumn_2015_nosmile/*");

foreach ($files as $path) {
    try {
        $image = new \Imagick($path);
    } catch (\Exception $e) {
        echo $e->getMessage(), "\n";
        continue;
    }

    if ($image->getIteratorIndex() > 1) {
        $uniqueFrameDelays = [];
        /** @var \Imagick $item */
        foreach ($image as $item) {
            $delay = $item->getImageDelay();

            if (!isset($uniqueFrameDelays[$delay])) {
                $uniqueFrameDelays[$delay] = 0;
            }

            $uniqueFrameDelays[$delay]++;
        }

        $uniqueFrameDelays = array_keys($uniqueFrameDelays);
        echo pathinfo($path, PATHINFO_FILENAME), ": GCF ", gcf_array($uniqueFrameDelays), ", [", join(', ', $uniqueFrameDelays), "]\n";
    }
}
/**
 * Calculates the Greatest Common Factor of two integers.
 *
 * @param int $a
 * @param int $b
 * @return int
 */
function gcf($a, $b)
{
    return ($b == 0) ? $a : gcf($b, $a % $b);
}

/**
 * Calculates the Least Common Multiple of an array of integers.
 *
 * @param array $array
 * @return integer
 */
function gcf_array($array)
{
    if (!is_array($array)) {
        throw new \InvalidArgumentException('lcm_array expects an array of integers.');
    }

    if (count($array) > 1) {
        $array[] = gcf(array_shift($array), array_shift($array));
        return gcf_array($array);
    }
    return $array[0];
}
