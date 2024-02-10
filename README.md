# Avoid mocking repositories by using in-memory implementations

This talk is based on my ["Avoid mocking repositories by using in-memory implementations" blog
post](https://danielrotter.at/2023/09/22/avoid-mocking-repositories-by-using-in-memory-implementations.html).

## Outline

- What makes a good test?
- The testing pyramid
- Problems with mocking
    - Hidden errors
    - Lots of duplication
    - Tight coupling
    - Hard to read
    - Difficult debugging
- Alternative approach
    - Define interface
    - Write abstract test for interface
    - Run abstract tests for real and in-memory implementation
    - Use in-memory implementation for other tests
- Advantages
    - Less hidden errors
    - Less duplicated code
    - Easy to read
    - Easy to debug
    - Less dependencies
- Disadvantages
    - Same functionality implemented twice
- Questions
