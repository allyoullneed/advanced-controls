<?php

namespace AllYoullNeed\AdvancedControls;

class ComponentIndex {
    private int $i = 0;

    public function increment() {
        $this->i += 1;
        return $this->i;
    }
    public function value() {
        return $this->i;
    }
}