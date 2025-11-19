<?php

class FiniteAutomation
{

    protected const POSSIBLE_STATES = [];   // All possible states for the finite state machine
    protected const ALPHABET = '';  // Alphabet as a string for acceptable input
    protected const INITIAL_STATE = ''; // State the FSM starts in 
    protected const TRANSITIONS = [];   // A 2D array where the indexes are [startingState, input] => final state
    protected const ACCEPTED_FINAL_STATES = []; // final states the FSM is allowed to end up in

    protected const STATE_OUTPUTS = []; // an array that mapes State => output

    protected $currentState; // This keeps track of the current state of the finite machine as it executes

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

    // Private setter function
    private function SetCurrentState($state)
    {
        $this->currentState = $state;
    }

    // Get current state
    public function GetCurrentState()
    {
        return $this->currentState;
    }

    public function GetOutput()
    {
        $currentState = $this->GetCurrentState();
        if (!isset(static::STATE_OUTPUTS[$currentState]))
        {
            throw new LogicException("No defined output for state: [$currentState]");
        }
        return static::STATE_OUTPUTS[$currentState];
    }

    // Accepts a string and feeds it character by character one at a time
    public function Execute($string)
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

        return $currentState;
    }

    // Reset FSM to initial state
    public function Reset()
    {
        $this->currentState = static::INITIAL_STATE;
    }
}

