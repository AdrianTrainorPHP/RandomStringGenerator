<?php

/**
 * Class RandomStringGenerator
 *
 * Helper used to quickly provide random alpha and alpha-numeric strings of a specified length
 */
class RandomStringGenerator
{
  /**
   * @var string $alphaUpper
   */
  private static $alphaUpper  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

  /**
   * @var string $alphaLower
   */
  private static $alphaLower  = 'abcdefghijklmnopqrstuvwxyz';

  /**
   * @var string
   */
  private static $numbers     = '0123456789';

  /**
   * RandomStringGenerator::randomAlpha ( int $length = default:0, string $upperLowerOrBoth = 'default:both|upper|lower' );
   *
   * returns a specified length string using random alpha chars or limited to only upper or lower case
   * Does not include diacritic alphas
   *
   * @param int $length
   * @param string $upperLowerOrBoth
   * @return string
   */
  public static function randomAlpha($length = 0, $upperLowerOrBoth = 'both')
  {
    return self::randomString($length, self::upperLowerOrBoth($upperLowerOrBoth));
  }

  /**
   * RandomStringGenerator::randomNumericString( int $length );
   *
   * returns a specified length string using numeric characters only.
   *
   * returns a specified length
   * @param int $length
   * @return string
   */
  public static function randomNumericString($length = 0)
  {
    return self::randomString($length, self::$numbers);
  }

  /**
   * RandomStringGenerator::randomAlphaNumeric ( int $length= default:0, string $upperLowerOrBoth = 'default:both|upper|lower' );
   *
   * returns a specified length string using random alpha and numeric chars - alphas may be limited to upper or lower case
   * Does not include diacritic alphas
   *
   * @param int $length
   * @param string $upperLowerOrBoth
   * @return string
   */
  public static function randomAlphaNumeric($length = 0, $upperLowerOrBoth = 'both')
  {
    return self::randomString($length, self::upperLowerOrBoth($upperLowerOrBoth, true));
  }

  /**
   * Private access
   *
   * returns the string from which random alphas and numbers are to be chosen
   *
   * @param string $upperLowerOrBoth
   * @param bool $includeNumbers
   * @return string
   */
  private static function upperLowerOrBoth($upperLowerOrBoth = 'both', $includeNumbers = false)
  {
    switch ($upperLowerOrBoth) {
      case 'upper':
        // returns uppers case alphas A-Z and includes numbers 0-9 if they are required
        return self::$alphaUpper . self::includeNumbers($includeNumbers);
        break;
      case 'lower':
        // returns lower case alphas a-z and includes numbers 0-9 if they are required
        return self::$alphaLower . self::includeNumbers($includeNumbers);
        break;
      default:
        // if numbers are required individual sets will be placed in between the upper and lower alpha sets
        // as well as being prepended and appended to the string. This brings the alpha:char ratio to 52:30
        return
          self::includeNumbers($includeNumbers) . self::$alphaUpper .
          self::includeNumbers($includeNumbers) . self::$alphaLower .
          self::includeNumbers($includeNumbers);
    }
  }

  /**
   * Private access
   *
   * Used internally to loop iterate for a number of times equal to length choosing
   * random characters from the chooseFrom pool.
   *
   * @param int $length
   * @param string $chooseFrom
   * @return string
   */
  private static function randomString($length = 0, $chooseFrom = '')
  {
    $returnString = '';

    if ($length > 0 && strlen($chooseFrom) > 0) {

      $mtRandMax = strlen($chooseFrom) - 1;

      for ($i = 0; $i < $length; $i++) {
        $returnString .= $chooseFrom[mt_rand(0, $mtRandMax)];
      }

    }

    return $returnString;
  }

  /**
   * Private access
   *
   * if numbers are to be included in the random selection pool, return the set of numbers
   * otherwise return an empty string i.e. ignore numbers
   *
   * @param bool $includeNumbers
   * @return string
   */
  private static function includeNumbers($includeNumbers = false)
  {
    return ($includeNumbers) ? self::$numbers : '';
  }
}