<?php

class hello
{

    public function handle()
    {
        return 'hello';
    }

    public function age($variables, $parameters)
    {
        return sprintf('%s::%d', $variables['name'], $variables['age']);
    }

}
