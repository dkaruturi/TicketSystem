<!DOCTYPE html>
<html>
 <head>
  <title>Fourth PHP Example</title>
 </head>
 <body>
 <?php
      /* PHP Comments can be in the style of C, C++/Java or Perl
         This multiline comment is in the C style */
      // The C++ / Java style is also fine
      # And the Perl style works as well (in case you are interested)

      // Note that with double quotes the variables are interpolated
      // into the string but with single quotes the variable names are
      // put into the strings.  If double-quotes are used, we can
      // prevent interpolation by putting a backslash before the
      // variable name, as shown.
      // Also note something about the \n in the first two lines below:
      // 	With double-quotes, the \n produces a newline character
      // as we are used to seeing with C++ or Java
      //	With single-quote, the \n produces the characters \ and n
      //
      // 	However, in NEITHER case does a new line show up on the web
      // page, since newlines are ignored by the html parser -- we need a
      // <br/> to get a newline on the web page.
$str1 = "helloo";
$str2 = "150";
$number = 150;
if (strcmp($str1, $str2) !== 0) {
    echo 'string will valued at 0 <br/>';
}

if($str1!=$str2){
    echo 'does the same thing as above <br/>';
}
$a = 1.234;
$b = 1;
if($a>$b){
  echo 'the float is greater than the int! <br/>';
}
if($str1<$number){
  echo 'strings have a value of 0 <br/>';
}


 ?>
</body>
</html>
