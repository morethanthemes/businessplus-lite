<?php

namespace Drupal\Tests\libraries\Kernel\LibrariesApi;

use Drupal\KernelTests\KernelTestBase;

/**
 * Tests basic Libraries API functions.
 *
 * @group libraries
 */
class LibrariesUnitTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['libraries'];

  /**
   * Tests libraries_get_path().
   */
  function testLibrariesGetPath() {
    // Note that, even though libraries_get_path() doesn't find the 'example'
    // library, we are able to make it 'installed' by specifying the 'library
    // path' up-front. This is only used for testing purposed and is strongly
    // discouraged as it defeats the purpose of Libraries API in the first
    // place.
    $this->assertEquals(libraries_get_path('example'), FALSE, 'libraries_get_path() returns FALSE for a missing library.');
  }

  /**
   * Tests libraries_prepare_files().
   */
  function testLibrariesPrepareFiles() {
    $expected = [
      'files' => [
        'js' => ['example.js' => []],
        'css' => ['example.css' => []],
        'php' => ['example.php' => []],
      ],
    ];
    $library = [
      'files' => [
        'js' => ['example.js'],
        'css' => ['example.css'],
        'php' => ['example.php'],
      ],
    ];
    libraries_prepare_files($library, NULL, NULL);
    $this->assertEquals($expected, $library, 'libraries_prepare_files() works correctly.');
  }

}
