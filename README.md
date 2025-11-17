This my implementation of the finite state machine assessment.

Design philosophy:
The goal was to be very easy for other developers to use given similar configuration as in the rubric. Through just defining some class constants, a developer should have a working finite state machine and some methods that should just work. I left methods The code utilizes late static binding for this purpose. What I did not the grander vision for the library, whether a developer has a finite state machine they want to work with in depth, or the intent was to work with many many different types of finite state machines. I wrote this assuming they were to work with it in depth.

Assumptions I've made:
- Code is accessible by other developers
- Intended use of the code is other developers have a finite state machine they want to work with and extend, as opposed to programatically creating many different finite state machines. 
- Exceptions are to be thrown when given invalid input/logic
- The FiniteAutomation class is not responsible for mapping states to outputs, this is left to the developer
- I believe the input can only be one character at a time for all finite state machines, due to my understanding of an alphabet

What I have like to do with more time:
- I would have liked to explore adding test cases for all possible extensions of the FiniteAutomation class
- I would have liked to add more test cases on the internal calls, but running Execute should go through all calls
- More test cases, most of my time was spent on testing tbh
