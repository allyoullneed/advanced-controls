<?php

namespace AllYouNeed\AdvancedControls;

class ComponentIndex {
    private int $i = 0;
    public function value() {
        $this->i += 1;
        return $this->i;
    }
    public function count() {
        return $this->i;
    }
}