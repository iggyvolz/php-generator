<?php

namespace Nette\PhpGenerator;

use Nette;

final class Hook
{
    use Traits\FunctionLike;
    use Traits\NameAware;
    use Traits\CommentAware;
    use Traits\AttributeAware;
    public const Constructor = '__construct';
    public function __toString(): string
    {
        return (new Printer)->printHook($this);
    }

    /** @throws Nette\InvalidStateException */
    public function validate(): void
    {
        if($this->name === "get") {
            if(count($this->parameters) !== 0) {
                throw new Nette\InvalidStateException("TODO");
            }
        } elseif($this->name === "set") {
            if(count($this->parameters) !== 1) { // TODO check type
                throw new Nette\InvalidStateException("TODO");
            }
        } else {
            throw new Nette\InvalidStateException();
        }
    }
}