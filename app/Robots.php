<?php

namespace App;

/**
 * Class Robots
 *
 * @package EllisTheDev\Robots
 */
class Robots {

	/**
	 * The lines for the robots.txt.
	 *
	 * @var array
	 */
	protected $lines = [];

	/**
	 * Generate the robots.txt data.
	 *
	 * @return string
	 */
	public function generate() {
		return implode(PHP_EOL, $this->lines);
	}

	/**
	 * Add a Sitemap to the robots.txt.
	 *
	 * @param string $sitemap
	 */
	public function addSitemap($sitemap) {
		$this->addLine('Sitemap: ' . $sitemap);
	}

	/**
	 * Add a User-agent to the robots.txt.
	 *
	 * @param string $userAgent
	 */
	public function addUserAgent($userAgent) {
		$this->addLine('User-agent: ' . $userAgent);
	}

	/**
	 * Add a Host to the robots.txt.
	 *
	 * @param string $host
	 */
	public function addHost($host) {
		$this->addLine('Host: ' . $host);
	}

	/**
	 * Add a disallow rule to the robots.txt.
	 *
	 * @param string|array $directories
	 */
	public function addDisallow($directories) {
		$this->addRuleLine($directories, 'Disallow');
	}

	/**
	 * Add a allow rule to the robots.txt.
	 *
	 * @param string|array $directories
	 */
	public function addAllow($directories) {
		$this->addRuleLine($directories, 'Allow');
	}

	/**
	 * Add a Clean-param rule to the robots.txt.
	 *
	 * @param string|array $directories
	 */
	public function addCleanParam($directories) {
		$this->addRuleLine($directories, 'Clean-param');
	}

	/**
	 * Add a rule to the robots.txt.
	 *
	 * @param string|array $directories
	 * @param string       $rule
	 */
	protected function addRuleLine($directories, $rule) {
		foreach ((array)$directories as $directory) {
			$this->addLine($rule . ': ' . $directory);
		}
	}

	/**
	 * Add a comment to the robots.txt.
	 *
	 * @param string $comment
	 */
	public function addComment($comment) {
		$this->addLine('# ' . $comment);
	}

	/**
	 * Add a spacer to the robots.txt.
	 */
	public function addSpacer() {
		$this->addLine('');
	}

	/**
	 * Add a line to the robots.txt.
	 *
	 * @param string $line
	 */
	protected function addLine($line) {
		$this->lines[] = (string)$line;
	}

	/**
	 * Reset the lines.
	 *
	 * @return void
	 */
	public function reset() {
		$this->lines = [];
	}
}