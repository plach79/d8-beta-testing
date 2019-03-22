<?php

/**
 * @file
 * Script to be used to populate the Drupal beta testing tracking spreadsheet.
 *
 * @param string $argv[1]
 *   The path of a CSV file containing an export of the Beta testing application
 *   form data.
 * @param string $argv[2]
 *   The tag being used to track issues created in the scope of the beta testing
 *   program, e.g. "8.7.0 beta testing".
 *
 * @see https://www.drupal.org/node/3042250
 * @see https://docs.google.com/spreadsheets/d/17j3-cvl3Jyu0f2wfF_Klr5mT5_GCteu6nMEVEgMQgH0/edit
 * @see https://docs.google.com/spreadsheets/d/1sZFZh8rV0f0jDO-mChwf9tyRDoanjrsOp85DiDmaKLs/edit
 */

$file_name = !empty($argv[1]) ? $argv[1] : '';
if (!file_exists($file_name)) {
  fprintf(STDERR, 'File not found: ' . $file_name . "\n");
  exit;
}

if (empty($argv[2])) {
  fprintf(STDERR, 'No issue queue tag specified.' . "\n");
  exit;
}
$tag = rawurlencode($argv[2]);

$input = fopen($file_name, 'r');
if ($input === FALSE) {
  fprintf(STDERR, 'Could not open: ' . $file_name . "\n");
  exit;
}

$usernames = [];

$output = fopen('php://output', 'w');

$headers = fgetcsv($input);
while ($row = fgetcsv($input)) {
  $input_data = array_combine($headers, $row);
  $username = $input_data['Primary contact Drupal.org username'];

  if (isset($usernames[$username])) {
    continue;
  }
  $usernames[$username] = $username;

  $output_data = [
    'username' => '=HYPERLINK("https://www.drupal.org/u/' . $username . '";"' . $username . '")',
    'Status' => 'n/a',
    'issues' => '=HYPERLINK("https://www.drupal.org/project/issues/search/drupal?issue_tags_op=%3D&issue_tags=' . $tag . '&submitted=' . $username . '";"issues")',
    'notes' => '',
  ];

  fputcsv($output, $output_data);
}

fclose($input);
