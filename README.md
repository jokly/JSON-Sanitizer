# JSON-Sanitizer

[![Build Status](https://travis-ci.org/jokly/JSON-Sanitizer.svg?branch=master)](https://travis-ci.org/jokly/JSON-Sanitizer)

## Requirements

1. [Virtual Box](https://www.virtualbox.org/wiki/Downloads)
2. [Vagrant](https://www.vagrantup.com/downloads.html) >= 2.0
3. Plugin vagrant-vbguest (`vagrant plugin install vagrant-vbguest`)

## Installation

1. `git clone https://github.com/jokly/JSON-Sanitizer.git`
2. `cd JSON-Sanitizer`
3. `vagrant plugin install vagrant-vbguest`
4. `vagrant up`

## How to run tests and code coverage

1. `vagrant ssh`
2. `cd /vagrant`
3. `make test`
4. `make coverage`

## Available types

1. Integer

    ```json
    {
        "data": "3",
        "type": "int"
    }
    ```

2. Float

    ```json
    {
        "data": "-5.3",
        "type": "float"
    }
    ```

3. String

    ```json
    {
        "data": "Hello World!",
        "type": "string"
    }
    ```

4. Phone number

    ```json
    {
        "data": "8(950)288-56-23",
        "type": "phone"
    }
    ```

5. Array

    ```json
    {
        "data": [
            {
                "data": "-5",
                "type": "int"
            },
            {
                "data": "3.25",
                "type": "float"
            }
        ],
        "type": "array"
    }
    ```

6. Typed array

    ```json
    {
        "data": [
            {
                "data": "Hello",
                "type": "string"
            },
            {
                "data": "World!",
                "type": "string"
            }
        ],
        "type": "array:string"
    }
    ```

7. Dictionary

    ```json
    {
        "data": {
            "my_str": {
                "data": "Hello",
                "type": "string"
            },
            "secod_el": {
                "data": "79.1",
                "type": "float"
            }
        },
        "type": "dict"
    }
    ```

## JSON data example

```json
[
    {
        "data": "15",
        "type": "int"
    },
    {
        "data": "7.1",
        "type": "float"
    }
]
```

## Errors

1. `InvalidJsonException`

    ```php
    "Invalid json object"
    ```

2. `UndefinedIndexException`

    ```php
    "Undefinde index: <index>"
    ```

3. `UnknownTypeException`

    ```php
    "Unknown type: <type>"
    ```

4. `RequiredTypeException`

    ```php
    "Element must be of the type <required_type>, <given type> given"
    ```

5. `UnexpectedTypeException`

    ```php
    "Unexpected type: <type>"
    ```

6. `InvalidTypeException => { InvalidIntException, InvalidFloatException, InvalidPhoneException }`

    ```php
    "Invalid <expected type: integer/float/phone>: <invalid data>"
    ```

## Errors example

```json
{
    "errors": [
        {
            "msg": "Undefinde index: 'data'"
        },
        {
            "msg": "Invalid 'integer': '5.1'"
        }
    ]
}
```
