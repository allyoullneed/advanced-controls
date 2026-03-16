<?php

namespace AllYoullNeed\AdvancedControls;

class ComponentIndex {
    private int $i = 0;
    public int $level= 100;

    public function increment() {
        $this->i += 1;
        return $this->i;
    }
    public function value() {
        return $this->i;
    }

    public function climb() {
    }

    public function descend() {
    }
}