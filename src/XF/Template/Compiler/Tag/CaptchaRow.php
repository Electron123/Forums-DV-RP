<?php

namespace XF\Template\Compiler\Tag;

use XF\Template\Compiler\Syntax\Tag;
use XF\Template\Compiler;

class CaptchaRow extends AbstractFormElement
{
	public function compile(Tag $tag, Compiler $compiler, array $context, $inlineExpected)
	{
		$withEscaping = [];
		foreach ($this->defaultRowOptions AS $option => $escaped)
		{
			if ($escaped)
			{
				$withEscaping[] = $option;
			}
		}

		$rowOptions = $this->compileAttributesAsArray($tag->attributes, $compiler, $context, $withEscaping);
		$indent = $compiler->indent();
		$rowOptionCode = "array(" . implode('', $rowOptions)  . "\n$indent)";

		if (isset($tag->attributes['force']))
		{
			$force = $compiler->compileForcedExpression($tag->attributes['force'], $context);
		}
		else
		{
			$force = 'false';
		}

		if (isset($tag->attributes['force-visible']))
		{
			$forceVisible = $compiler->compileForcedExpression($tag->attributes['force-visible'], $context);
		}
		else
		{
			$forceVisible = 'false';
		}

		$contentHtml = "{$compiler->templaterVariable}->func('captcha', array({$force}, {$forceVisible}))";

		return "{$compiler->templaterVariable}->formRowIfContent($contentHtml, $rowOptionCode)";
	}
}