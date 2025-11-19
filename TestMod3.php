<?php

require_once __DIR__ . "/Mod3.php";
require_once __DIR__ . "/BadMod3.php";

RunTestCases();
// TestGeneric();

function RunTestCases()
{
    // The below runs tests cases on a poorly defined finite automation
    TestBadMod3();

    // The below shows what happens when all test cases pass
    TestMod3();
    
}

function logMsg($str)
{
    echo $str . "\n";
}

// This function runs test cases on a correct implementation of mod3
function TestMod3()
{
    logMsg("********\nTesting an correct implementation of Mod3, all test cases should pass\n********");
    $totalCases = 0;
    $totalPass = 0;
    $mod3 = new Mod3();

    TestMod3_OutputValidation($mod3, $totalCases, $totalPass);
    TestMod3_ExceptionHandlingValidation($mod3, $totalCases, $totalPass);


    logMsg("{$totalPass}/{$totalCases} passed");
    if ($totalCases == $totalPass)
    {
        logMsg("Success");
    }
    else
    {
        logMsg("Fail");
    }
}

// This function runs the same test cases on a poorly defined version of mod3, testing the test cases 
function TestBadMod3()
{
    logMsg("********\nTesting an incorrect implementation of Mod3, many test cases should fail\n********");
    $totalCases = 0;
    $totalPass = 0;
    $mod3 = new BadMod3();

    TestMod3_OutputValidation($mod3, $totalCases, $totalPass);
    TestMod3_ExceptionHandlingValidation($mod3, $totalCases, $totalPass);


    logMsg("{$totalPass}/{$totalCases} passed");
    if ($totalCases == $totalPass)
    {
        logMsg("Success");
    }
    else
    {
        logMsg("Fail");
    }
}

// This tests a variety of different unexpected inputs
function TestMod3_ExceptionHandlingValidation(&$mod3, &$totalCases, &$totalPass)
{

    $totalPass += (int) ValidateUnhandledInput($mod3, '11 11');
    $totalCases+= 1;
    
    $totalPass += (int) ValidateUnhandledInput($mod3, 'abc');
    $totalCases += 1;

    $totalPass += (int) ValidateUnhandledInput($mod3, []);
    $totalCases += 1;

    $totalPass += (int) ValidateUnhandledInput($mod3, new STDClass());
    $totalCases += 1;

    $totalPass += (int) ValidateUnhandledInput($mod3, '2');
    $totalCases += 1;

    $totalPass += (int) ValidateUnhandledInput($mod3, '112');
    $totalCases += 1;

}

function ValidateUnhandledInput(&$finiteAutomation, $input)
{
    $class = get_class($finiteAutomation);
    try {
        $finiteAutomation->Execute($input);
        
        logMsg("[{$class}] Fail: Input [" . print_r($input, true) . "] does not lead UnexpectedValueException" );
    }
    catch (Throwable $e)
    {
        $finiteAutomation->Reset();
        if ($e instanceof UnexpectedValueException)
        {
            logMsg("[{$class}] Success: Input [" . print_r($input, true) . "] leads to UnexpectedValueException");
            return true;
        }
        else
        {
            logMsg("[{$class}] Fail: Input [" . print_r($input, true) . "] does not lead UnexpectedValueException. Caught different error: ". $e->getMessage() );
            return false;
        }
    }

}

function TestMod3_OutputValidation(&$mod3, &$totalCases, &$totalPass)
{

    // Do some known input outputs defined in the requirements
    $totalPass += (int) ValidateOutput($mod3, "1101", '1');
    $totalCases += 1;

    $totalPass += (int) ValidateOutput($mod3, "1110", '2');
    $totalCases += 1;

    $totalPass += (int) ValidateOutput($mod3, "1111", '0');
    $totalCases += 1;


    // Test values from 1 to 99999

    for ($i= 0; $i < 100; $i++)
    {
        $result = $i % 3;
        $binaryString = decbin($i);

        $totalPass += (int) ValidateOutput($mod3, $binaryString, $result);
        $totalCases += 1;
    }
}

function ValidateOutput(&$finiteAutomation, $input, $expectedValue)
{
    $class = get_class($finiteAutomation);
    try
    {
        $finiteAutomation->Execute($input);
        $output = $finiteAutomation->GetOutput();
        $finiteAutomation->Reset();
        if ($output != $expectedValue)
        {
            logMsg("[{$class}] Fail: Input [" . print_r($input, true) . "] leads to unexpected output [{$output}]. Expected output: " . $expectedValue);
            return false;
        }

        logMsg("[{$class}] Success: Input [" . print_r($input, true) . "] leads to expected output [{$output}]");
        return true;
    }
    catch(Throwable $e)
    {
        $finiteAutomation->Reset();
        logMsg("[{$class}] Fail: Input [" . print_r($input, true) . "] leads to unhandled exception. [".$e->getMessage()."]");
        return false;
    }
    
}
// To do
// I wanted to explore testing all definitions of the class at once
// My plan was to automatically generate input based off the defined alphabet, but this would require more thought
function TestGeneric()
{
    // Do basic testing on all instances of the class
    foreach (get_declared_classes() as $className) {
        if (is_subclass_of($className, 'FiniteAutomation')) {
            logMsg("I am " . $className);
            // Do testing logic here
        }
    }

}

