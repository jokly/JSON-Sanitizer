[![Build Status](https://travis-ci.org/jokly/JSON-Sanitizer.svg?branch=master)](https://travis-ci.org/jokly/JSON-Sanitizer)

# Requirements
1. [Virtual Box](https://www.virtualbox.org/wiki/Downloads)
2. [Vagrant](https://www.vagrantup.com/downloads.html) >= 2.0
3. Plugin vagrant-vbguest (`vagrant plugin install vagrant-vbguest`)

# Installation
1. `git clone https://github.com/jokly/JSON-Sanitizer.git`
2. `cd JSON-Sanitizer`
3. `vagrant plugin install vagrant-vbguest`
4. `vagrant up`

# Available types

1. Integer
```
{
    "data": "3",
    "type": "int"
}
```

2. Float
```
{
    "data": "-5.3",
    "type": "float"
}
```

3. String
```
{
    "data": "Hello World!",
    "type": "string"
}
```

4. Phone number
```
{
    "data": "8(950)288-56-23",
    "type": "phone"
}
```

5. Array
```
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
```
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
```
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

# JSON data example

```
[
    {
        "data": "15",
        "type": "int"                                                                                      
    },
    {
        "data": "7.1",
        "type": "float"
    },
    ...
]
```

# Errors

```
{
    "errors": [
        {
            "msg": "Invalid json object"
        },
        ...
    ]
}
```
