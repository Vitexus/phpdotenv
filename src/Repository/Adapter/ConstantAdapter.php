<?php

declare(strict_types=1);

namespace Dotenv\Repository\Adapter;

use PhpOption\Option;
use PhpOption\Some;

final class ConstantAdapter implements AdapterInterface
{
    /**
     * Create a new server constant adapter instance.
     *
     * @return void
     */
    private function __construct()
    {
        //
    }

    /**
     * Create a new instance of the adapter, if it is available.
     *
     * @return \PhpOption\Option<\Dotenv\Repository\Adapter\AdapterInterface>
     */
    public static function create()
    {
        /** @var \PhpOption\Option<AdapterInterface> */
        return Some::create(new self());
    }

    /**
     * Read an constant, if it exists.
     *
     * @param string $name
     *
     * @return \PhpOption\Option<string>
     */
    public function read(string $name)
    {
        /** @var \PhpOption\Option<string> */
        return Option::fromValue(constant($name))
            ->map(static function ($value) {
                if ($value === false) {
                    return 'false';
                }

                if ($value === true) {
                    return 'true';
                }

                return $value;
            })->filter(static function ($value) {
                return \is_string($value);
            });
    }

    /**
     * Write to an constant, if possible.
     *
     * @param string $name
     * @param string $value
     *
     * @return bool
     */
    public function write(string $name, string $value)
    {
        define($name, $value);

        return true;
    }

    /**
     * Delete of constant is inpossible possible.
     *
     * @param string $name
     *
     * @return bool
     */
    public function delete(string $name)
    {

        return false;
    }
}
