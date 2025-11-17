<?php

class FiniteAutomation
{

    protected const POSSIBLE_STATES = [];
    protected const ALPHABET = '';
    protected const INITIAL_STATE = '';
    protected const TRANSITIONS = [];
    protected const ACCEPTED_FINAL_STATES = [];

    protected $currentState;

    public function __construct()
    {
        $this->currentState = static::INITIAL_STATE;
    }

    public function TakeInput($char)
    {
        if (!is_scalar($char))
        {
            throw new UnexpectedValueException("Input [" . print_r($char, true) . "] must be a string of length 1");
        }
        // Be generous in the input we accept
        $char = strval($char);

        // Validate the length
        if (strlen($char) != 1)
        {
            throw new LengthException("Input [{$char}] must be a string of length 1");
        }

        // Validate input is part of the alphabet
        if (strpos(static::ALPHABET, $char) === false)
        {
            throw new UnexpectedValueException("Input [{$char}] must be one of these characters: " . static::ALPHABET);
        }

        $currentState = $this->GetCurrentState();

        // Validate a transition exists
        if (!isset(static::TRANSITIONS[$currentState][$char]))
        {
            
            throw new LogicException("There is no defined transition function for the current state and input [{$this->currentState}] [$char]");
        }

        // Get transition from mapping
        $newState = static::TRANSITIONS[$currentState][$char];
        $this->SetCurrentState($newState);
    }

    private function SetCurrentState($state)
    {
        $this->currentState = $state;
    }

    public function GetCurrentState()
    {
        return $this->currentState;
    }

    // Accepts a string and feeds it character by character one at a time
    public function Execute($string, $resetAfter = false)
    {
        if (!is_scalar($string))
        {

            throw new UnexpectedValueException("Input [".print_r($string)."] must be a string");
        }

        $string = strval($string);
        $characters = str_split($string);

        foreach($characters as $character)
        {
            $this->TakeInput($character);
        }

        // Get the current state
        $currentState = $this->GetCurrentState();

        // Is it part of the accepted final states?
        if (!in_array($currentState, static::ACCEPTED_FINAL_STATES))
        {
            throw new LogicException("Current state [{$currentState}] is not an accepted final state [".implode(",", static::ACCEPTED_FINAL_STATES)."]");
        }

        if ($resetAfter)
        {
            $this->Reset();
        }

        return $currentState;
    }

    public function Reset()
    {
        $this->currentState = static::INITIAL_STATE;
    }
}

