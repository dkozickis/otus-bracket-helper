<?php

/*
 * This file is part of the bracket-helper project for otus.ru studies.
 *
 * (c) Deniss Kozickis <deniss.kozickis@gmail.com>
 *
 * Use and reuse as much as you want.
 * Distributed under Apache License 2.0
 */

namespace Dkozickis;

class BracketHelper
{
    // Используем константы, немного легче читаемо в if/elseif в isBalanced()
    const OPENING_BRACKET = '(';
    const CLOSING_BRACKET = ')';

    /**
     * Основная публичная функция.
     *
     * Сначала проверяет содержит ли строка только валидные символы, если нет - кидает InvalidArgumentException.
     * Если все символы валидны - проверят сбалансирована ли строка.
     *
     * @param string $string
     *
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function isValid(string $string): bool
    {
        if ($this->containsInvalidSymbols($string)) {
            throw new \InvalidArgumentException('Строка содержит недопустимые символы.');
        }

        return $this->isBalanced($string);
    }

    /**
     * В балансе ли строка (йода стайл везде лезет). Для каждой скобки "(" должна быть закрывающая ")".
     *
     * @param string $string
     *
     * @return bool
     */
    private function isBalanced(string $string): bool
    {
        $balance = 0;

        for ($i = 0; $i < strlen($string); ++$i) {
            // К строке можно применять доступ как к массиву.
            // Нас не заботит, что в строке может быть мултьтибайт символ т.к. мы бы уже кинули InvalidArgumentException.
            $character = $string[$i];

            if (self::OPENING_BRACKET === $character) {
                // Открывашка - увеличить баланс.
                ++$balance;
            } elseif (self::CLOSING_BRACKET === $character) {
                // Закрывашка - уменшить баланс.
                --$balance;
            }

            // Early return if we have more closing brackets than opening brackets.
            // Ранний возврат если баланс ушел в минус.
            if ($balance < 0) {
                return false;
            }
        }

        // Строка в балансе или нет.
        // Если было больше закрывашек - мы уже вернули false раньше.
        // Тут false будет если больше открывашек.
        // True - если все в балансе.
        return 0 === $balance;
    }

    /**
     * Проверяет, что сторока содержит только разрешенные символы - "(", ")", "\t", "\r", "\n", пробел "\s".
     *
     * Функций возвращает true если в строке есть невалидные символы, false если нет.
     * Просто люблю regexp.
     *
     * @param string $string
     *
     * @return bool
     */
    private function containsInvalidSymbols(string $string): bool
    {
        // Тут preg_match вернет false если есть невалидные симолы
        // Надо инвертировать это при помощи "!"
        return !preg_match("/^([()\r\n\t\s]+)$/", $string);
    }
}
