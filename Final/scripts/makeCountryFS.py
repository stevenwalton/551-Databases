#!/usr/bin/python3

import argparse
import os
import time

#country_var = "US"

def arglist():
    parser = argparse.ArgumentParser(prog="Generate Sites")
    parser.add_argument('-c', '--country', default='default', type=str,
                        help="country we wish to make a php file for")
    return parser.parse_args()

def makeCountry(country_var):
    pathname = 'Countries'
    print(f"Checking for {pathname}")
    i = 0
    while(not os.path.exists(pathname)):
        pathname = "../" + pathname
        print(f"Checking for {pathname}")
        i += 1
        if (i > 10):
            exit(1)
    skel = f'''
<?php
include_once '../../src/connect.php';
include_once '../../src/basicFunctions.php';
include_once '../../src/stateFunctions.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Climbing Project</title>
    </head>
    <body>
    <a href="/~swalton2/551/Final">
    <img src="/~swalton2/551/Final/media/Title.png">
    </a>
    <br>
    Country: {country_var}
    <br>
    Available States
    <br>
    <?php
    $object = new State;
    $states = $object->getStatesInCountryNamed("{country_var}");
    if ($states == NULL)
    {{
        echo("Sorry, there are no states listed for this country");
    }}
    ?>
    <?php foreach ($states as $state): ?>
        <a href="./<?php echo($state); ?>"> <?php echo($state); ?></a>
    <?php endforeach; ?>
    <?php include '../../footer.php';?>    
</html>
    '''
    
    print(f"Making file {pathname}/{country_var}/index.php")
    os.mkdir(pathname + "/" + country_var)
    with open(pathname + "/" + country_var+"/index.php",'w') as f:
        f.write(skel)

if __name__ == '__main__':
    args = arglist()
    makeCountry(args.country)
