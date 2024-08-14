<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette\PhpGenerator\Traits;

use Nette;
use Nette\PhpGenerator\Hook;


/**
 * @internal
 */
trait HooksAware
{
	/** @var array<string, Hook> */
	private array $hooks = [];


	/**
	 * Replaces all hooks.
	 * @param  Hook[]  $hooks
	 */
	public function setHooks(array $hooks): static
	{
        (function (Hook ...$hook) {})(...$hooks);
		$this->hooks = [];
		foreach ($hooks as $m) {
			$this->hooks[strtolower($m->getName())] = $m;
		}

		return $this;
	}


	/** @return Hook[] */
	public function getHooks(): array
	{
		$res = [];
		foreach ($this->hooks as $m) {
			$res[$m->getName()] = $m;
		}

		return $res;
	}


	public function getHook(string $name): Hook
	{
		return $this->hooks[strtolower($name)] ?? throw new Nette\InvalidArgumentException("Hook '$name' not found.");
	}


	/**
	 * Adds a hook. If it already exists, throws an exception or overwrites it if $overwrite is true.
	 */
	public function addHook(string $name, bool $overwrite = false): Hook
	{
		$lower = strtolower($name);
		if (!$overwrite && isset($this->hooks[$lower])) {
			throw new Nette\InvalidStateException("Cannot add method '$name', because it already exists.");
		}
		$hook = new Hook($name);

		return $this->hooks[$lower] = $hook;
	}


	public function removeHook(string $name): static
	{
		unset($this->hooks[strtolower($name)]);
		return $this;
	}


	public function hasHook(string $name): bool
	{
		return isset($this->hooks[strtolower($name)]);
	}
}
