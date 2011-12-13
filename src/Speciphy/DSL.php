<?php
namespace Speciphy\DSL;

use Speciphy\ExampleGroup;
use Speciphy\Example;
use Speciphy\Pending;
use Speciphy\Subject;

function describe($description, $specElements = NULL) {
    $exampleGroup = new ExampleGroup($description);

    if (isset($specElements) && ! is_array($specElements)) {
        $args = func_get_args();
        array_shift($args);
        $specElements = $args;
    }

    if (isset($specElements)) {
        foreach ($specElements as $key => $value) {
            if (is_int($key)) {
                if ($value instanceof ExampleGroup ||
                    $value instanceof Example ||
                    $value instanceof Pending) {
                    $exampleGroup->addChild($value);
                } else if ($value instanceof Subject) {
                    $exampleGroup->setSubject($value);
                } else if (is_string($value)) {
                    $exampleGroup->addChild(new Pending($value));
                }
            } else if (is_string($key)) {
                switch ($key) {
                case 'subject':
                    $exampleGroup->setSubject(new Subject($value));
                    break;
                case 'before':
                    $exampleGroup->setBeforeHook($value);
                    break;
                case 'after':
                    $exampleGroup->setAfterHook($value);
                    break;
                case 'before_all':
                case 'beforeAll':
                    $exampleGroup->setBeforeAllHook($value);
                    break;
                case 'after_all':
                case 'afterAll':
                    $exampleGroup->setAfterAllHook($value);
                    break;
                }
            }
        }
    }

    return $exampleGroup;
}

function context($description, $examples = NULL) {
    return call_user_func_array('\\Speciphy\\DSL\\describe', func_get_args());
}

function it($description, $block = NULL) {
    if (is_null($block)) {
        return new Pending($description);
    } else {
        return new Example($description, $block);
    }
}

function subject($block) {
    return new Subject($block);
}
