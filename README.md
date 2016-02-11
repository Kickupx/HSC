# HSC
Hierarchal String Config, For dealing with customizable strings where input is wanted in the middle of it.
For example HTML strings.

#Configformat

Really simple

<<<<< NAME

<body>
======
</body>

>>>>> /NAME

Where NAME is the name of the config. Normal characters, numbers, _ and . are recognized
===== denotes where insertion is meant to happen.
And last row denotes the end. Notice name is required.



#Usage

Dealing with this is done using the Parser and Document class.

##Parse

 ```php
 $code =
      "
      <<<<<< Config
         Text, Text
         ===========
         More More
      >>>>>>> /Config

      <<<<<<<<< Super
         Start, Start
         ===============
         End End
      >>>>>>>>> /Super

 ";
 $parser = new Parser();
 $doc = $parser->parse($code);
 ```
 
 
 ##Get entries
 
 ```php
 $doc->get('Config');
 $doc->get('Config', 'default start', 'default end');
 ```
 
 ##Add entries
 
 ```php
 $doc->addEntry(new Entry('Config');
 $doc->addEntry(new Entry('Config', 'default start', 'default end'));
 ```

 ##Serializing

 ```php
 $doc->__toString();
 ```