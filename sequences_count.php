<?php

/*
Author: Juan M Navarro
Date: August 13, 2017
Problem: Your goal is to find the number of occurrences of a particular string within a group of characters. The letters in the string do not need to be next to each other but must appear in sequential order. 

For example, the following sequence contains four occurrences of the string "abc" 

Sequence "aabcc"

Occurrences

aabcc
aabcc
aabcc
aabcc

Given the input file, print the number of occurrences of the string "abc" for each line. Considering the number of occurrences may be so large, you should print only the last five digits (right aligned, padded to 5 digits with zeros). 
*/


/*
 * Parameters: $input_string_array - the input string represented as an array of characters
 *             $sample_string_array - the sample string represented as an array of characters
 *             $i_index - position for $input_string_array to end the search at
 *             $j_index - position for $sample_string_array to end the search at
 * Returns: A boolean indicating whether $sample_string_array contains (from position $j_index down to 0) each character contained in
 *          $input_string_array (from position $i_index down to 0) 
 */
function has_at_least_one_character_of_each_up_to_position($input_string_array, $sample_string_array, $i_index, $j_index)
{
   $has_at_least_one_character_up_to_position = true;
   $position_found = $j_index;
   $chars_found = 0;

   for($i = $i_index; $i >= 0 ; $i--)
   {
      $is_ith_character_found = false;

      for($j = $position_found; $j >= 0; $j--)
      {
         //var_dump($i . ", " . $j . " - " . $input_string_array[$i] . ", " . $sample_string_array[$j] . " - " . ($input_string_array[$i] == $sample_string_array[$j]));
         if($input_string_array[$i] == $sample_string_array[$j])
         {
            $position_found = $j-1;
            $chars_found++;
            $is_ith_character_found = true;
            break;
         }
      }

      if($is_ith_character_found == false)
      {
         break;
      }
   }

   //var_dump($chars_found . " - " . $i_index);
   if($chars_found != $i_index + 1)
   {
      $has_at_least_one_character_up_to_position = false;
   }

   return $has_at_least_one_character_up_to_position;
}

/*
 * Parameters: $input_string_array - the input string represented as an array of characters
 *             $sample_string_array - the sample string represented as an array of characters
 *             $i_index - position for $input_string_array to start searching from
 *             $j_index - position for $sample_string_array to start searching from
 * Returns: A boolean indicating whether $sample_string_array contains (from position $j_index onwards) each character contained in
 *          $input_string_array (from position $i_index onwards) 
 */
function has_at_least_one_character_of_each_remaining_from_position($input_string_array, $sample_string_array, $i_index, $j_index)
{
   $has_at_least_one_character_remaining = true;
   $position_found = $j_index;
   $chars_found = 0;

   for($i = $i_index; $i < count($input_string_array); $i++)
   {
      $is_ith_character_found = false;

      for($j = $position_found; $j < count($sample_string_array); $j++)
      {
         //var_dump($i . ", " . $j . " - " . $input_string_array[$i] . ", " . $sample_string_array[$j] . " - " . ($input_string_array[$i] == $sample_string_array[$j]));
         if($input_string_array[$i] == $sample_string_array[$j])
         {
            $position_found = $j+1;
            $chars_found++;
            $is_ith_character_found = true;
            break;
         } 
      }

      if($is_ith_character_found == false)
      {
         break;
      }
   } 

   if($chars_found != (count($input_string_array) - $i_index ))
   {
      $has_at_least_one_character_remaining = false;
   }

   return $has_at_least_one_character_remaining;
}

/*$input_string = "abc";
$sample_string = "aabcc";

$input_string_array = str_split($input_string);
$sample_string_array = str_split($sample_string);

$result = has_at_least_one_character_of_each_remaining_from_position($input_string_array, $sample_string_array, 4, 6);
//$result = has_at_least_one_character_of_each_up_to_position($input_string_array, $sample_string_array, 4, 6);
var_dump($result);
exit;*/

/*
 * Parameters: $input_string_array - the input string represented as an array of characters
 *             $sample_string_array - the sample string represented as an array of characters
 * Returns: An array denoting how many times each character in the $input_string_array appears in $sample_string_array, while keeping the
 *          constraint that the first i characters of $input_string_array appear in the $sample_string_array, and that the characters from i to the end 
 *          of $input_string_array also appear in the $sample_string_array
 */
function get_count_of_occurrences($input_string_array, $sample_string_array)
{
   $output = array();

   for($i = 0; $i < count($input_string_array); $i++)
   {
      $count = 0;  

      for($j = 0; $j < count($sample_string_array); $j++)
      {
         if($sample_string_array[$j] == $input_string_array[$i] && 
            has_at_least_one_character_of_each_remaining_from_position($input_string_array, $sample_string_array, $i+1, $j+1) &&
            has_at_least_one_character_of_each_up_to_position($input_string_array, $sample_string_array, $i-1, $j-1))
         {
            $count++;
         }
      }

      // store the count for each character $i in $input_string_array
      $output[] = $count;
   } 

   //var_dump($output);
   return $output;
}

/*
 * Parameters: $count - integer to be formatted
 * Returns: string with 5 characters max, padded with leading 0's if $count is less than 5 digits long
 */
function format_output_count($count)
{
   $count_array = str_split($count);
   $output = "";
   $num_digits_to_display = 5;

   if(count($count_array) > $num_digits_to_display)
   {
      // just grab the last 5 digits
      for($i = (count($count_array) - $num_digits_to_display); $i < count($count_array); $i++)
      {
         $output .= $count_array[$i];
      }
   }
   else
   {
      // get number of leading zeros needed
      $num_leading_zeros = $num_digits_to_display - count($count_array);

      // append leading zeros if needed
      for($i = 0; $i < $num_leading_zeros; $i++)
      {
         $output .= "0";
      }

      // append remaining digits from the $count_array
      for($i = 0; $i < count($count_array); $i++)
      {
         $output .= $count_array[$i];
      }
   }

   return $output;
}

$input_string = "abc";
$input_file = "sequences_a.txt";

// open file for reading
$handle = fopen($input_file, "r");

if ($handle)
{
   $i = 0;
   while (($sample_string = fgets($handle)) !== false)
   {
      // process the line read.
      $input_string_array = str_split($input_string);
      $sample_string_array = str_split($sample_string);

      $count_of_occurrences = get_count_of_occurrences($input_string_array, $sample_string_array);

      $count = 1; // set to 1, since we are multiplying
      foreach($count_of_occurrences as $count_of_occurrence)
      {
         // multiply by the count of each occurrence. Will be 0 if no occurrences found
         $count *= $count_of_occurrence;
      }

      $count = number_format($count, 0, ".", ""); // avoid scientific notation
      $count = format_output_count($count);
      echo "Line " . $i . ": " . $count . "\n";

      $i++;
   }

   fclose($handle);
}
else
{
   echo "Error opening the file.\n";
}

?>
