# Drupal 8 Beta Testing Tools
Supporting tools for the Drupal 8 Beta Testing program.

## Populate the tracking spreadheet
The `populate-spreadsheet.php` script can be used to populate the Drupal beta
testing tracking spreadsheet:
* Export the live submissions spreadsheet as CSV, e.g. `~/Desktop/beta_testers.csv`
* Duplicate the Drupal beta testing tracking spreadsheet template. Store the
  output of this script in a CSV file and import it there. From the Google
  Spreadsheet UI do:
  
  `File > Import > Upload > Append to the current sheet`

  Example usage:
  
  `php populate-spreadsheet.php ~/Desktop/beta_testers.csv "8.7.0 beta testing"  > ~/Desktop/out.csv`
