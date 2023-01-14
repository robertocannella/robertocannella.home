<?php

class Trie {

    private Node $root;

    public function __construct()
    {
        $this->root = new Node( ' ');
    }

    public function insert(string $word):void {
        $current = $this->root;
        $chars = str_split($word);

        foreach($chars as $ch){
            $index = self::$asciiValues[$ch];

            if (!isset($current->children[$index])){
                $current->children[$index] = new Node($ch);
            }
            $current = $current->children[$index];
        }
        $current->isEndOfWord = true;
    }

    public function containsWord(string $word):void{
        $current = $this->root;
        $chars = str_split($word);
        foreach($chars as $ch){
            $index = self::$asciiValues[$ch];

            if (!$current->hasChild($index)){
               // write_log("NO CHILD");
            }
        }

    }



    static array $asciiValues = array(
        "a" => 0,
        "b" => 1,
        "c" => 2,
        "d" => 3,
        "e" => 4,
        "f" => 5,
        "g" => 6,
        "h" => 7,
        "i" => 8,
        "j" => 9,
        "k" => 10,
        "l" => 11,
        "m" => 12,
        "n" => 13,
        "o" => 14,
        "p" => 15,
        "q" => 16,
        "r" => 17,
        "s" => 18,
        "t" => 19,
        "u" => 20,
        "v" => 21,
        "w" => 22,
        "x" => 23,
        "y" => 24,
        "z" => 25
    );
}

class Node {
    private string $value;
    public array $children;
    public bool $isEndOfWord;
    public function __construct(string $value)
    {
        $this->value = $value;
    }
    public function __toString()
    {
        return "Value" . $this->value;
    }
    public function hasChild(string $ch): bool
    {
        write_log($this->children);
        return array_key_exists($ch,$this->children);
    }
}