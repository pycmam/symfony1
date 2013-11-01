<?php

class sfPatternEventDispatcher extends sfEventDispatcher
{
    public function getListeners($name)
    {
        $listeners = array();

        foreach (array_keys($this->listeners) as $key)
        {
            if ($key === $name) {
                $listeners = array_merge($listeners, $this->listeners[$key]);
            } else
            if (strpos($key, '*') !== false)
            {
                $pattern = '/^'. strtr($key, array('.' => '\.', '*' => '.+?')) . '$/m';
                if (preg_match($pattern, $name))
                {
                    $listeners = array_merge($listeners, $this->listeners[$key]);
                }
            }
        }

        return $listeners;
    }
}