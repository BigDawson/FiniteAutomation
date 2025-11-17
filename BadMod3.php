<?php

require_once __DIR__ . "/FiniteAutomation.php";

class BadMod3 extends FiniteAutomation
{
    const STATE_S0 = 'S0';
    const STATE_S1 = 'S1';
    const STATE_S2 = 'S2';

    protected const POSSIBLE_STATES = [self::STATE_S0, self::STATE_S1, self::STATE_S2];
    protected const ALPHABET = '01';
    protected const INITIAL_STATE = self::STATE_S0;
    protected const ACCEPTED_FINAL_STATES = [self::STATE_S0];

    protected const TRANSITIONS = array(
        'S0' => ['0' => self::STATE_S0, '1' => self::STATE_S1],
        'S1' => ['0' => self::STATE_S0, '1' => self::STATE_S1],
        'S2' => ['0' => self::STATE_S1, '1' => self::STATE_S2]
    );
}