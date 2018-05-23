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
