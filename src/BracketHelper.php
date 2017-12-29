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
    /**
     * Main entry function.
     * Основная публичная функция.
     *
     * Check if string contains valid symbols first. Throws InvalidArgumentException if not.
     * If string contains all valid symbols, checks if string is balanced.
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
            throw new \InvalidArgumentException('String contains invalid symbols');
        }

        return $this->isBalanced($string);
    }

    /**
     * Checks if string is balanced each "(" has ")".
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
            // We can access string as array.
            // We don't care about multibyte string because we filtered string with invalid symbols already.
            // К строке можно применять доступ как к массиву.
            // Нас не заботит, что в строке может быть мултьтибайт символ т.к. мы бы уже кинули InvalidArgumentException.
            $character = $string[$i];

            if ('(' === $character) {
                // If opening bracket - increase balance.
                // Открывашка - увеличить баланс.
                ++$balance;
            } elseif (')' === $character) {
                // If closing balance - decrease balance.
                // Закрывашка - уменшить баланс.
                --$balance;
            }

            // Early return if we have more closing brackets than opening brackets.
            // Ранний возврат если баланс ушел в минус.
            if ($balance < 0) {
                return false;
            }
        }

        // Return whether the brackets in the string are balanced.
        // If we had more closing brackets then early "return false;" was already done
        // This will return false if we had more opening brackets.
        // This will return true if brackets are balanced
        // Строка в балансе или нет.
        // Если было больше закрывашек - мы уже вернули false раньше.
        // Тут false будет если больше открывашек.
        // True - если все в балансе.
        return 0 === $balance;
    }

    /**
     * Check if string contains only "(", ")", "\t", "\r", "\n", whitespace "\s".
     * Проверяет, что сторока содержит только разрешенные символы - "(", ")", "\t", "\r", "\n", пробел "\s".
     *
     * Function returns true if string contains invalid symbols. False otherwise.
     * Функций возвращает true если в строке есть невалидные символы, false если нет.
     * Просто люблю regexp.
     *
     * @param string $string
     *
     * @return bool
     */
    private function containsInvalidSymbols(string $string): bool
    {
        // preg_match will return false if there are invalid symbols
        // We inverse that with "!"
        // Тут preg_match вернет false если есть невалидные симолы
        // Надо инвертировать это при помощи негации "!"
        return !preg_match("/^([()\r\n\t\s]+)$/", $string);
    }
}
