<?php

namespace App\AI;

use App\Diario;
use App\Miembro;
use Phpml\Classification\SVC;
use Phpml\ModelManager;
use Phpml\SupportVectorMachine\Kernel;

class MemberFromText
{
    private $regexp = '/\W+/';
    public $tokens = [];
    public $valores = [];
    private $filepath;
    /**
     * @var SVC
     */
    private $classifier;

    public function __construct()
    {
        $this->filepath = base_path('ai/' . (new \ReflectionClass($this))->getShortName()) . '.ai';
        if (file_exists($this->filepath)) {
            foreach (json_decode(file_get_contents($this->filepath . '.json')) as $k => $v) {
                $this->$k = $v;
            }
            $modelManager = new ModelManager();
            $this->classifier = $modelManager->restoreFromFile($this->filepath);
        } else {
            $this->classifier = new SVC(Kernel::LINEAR, $cost = 1000);
            $this->train();
        }
    }

    public function train()
    {
        $this->tokens = [];
        $this->valores = [];
        $diarios = Diario::where('detalle', '!=', 'Apertura caja')
            ->where('detalle', '!=', 'Saldo Inicial')
            ->get();
        $samples = [];
        $labels = [];
        foreach ($diarios as $diario) {
            if ($diario->miembro_id) {
                $vectorMiembro = $this->getVectorMiembro($diario->miembro_id);
                $words = $this->description2vector($diario->detalle);
                foreach ($words as $w) {
                    $this->valores[$w][] = $vectorMiembro;
                }
            }
        }
        foreach ($this->valores as $i => $v) {
            $this->valores[$i] = $this->mat2vec($v, count($v));
        }
        foreach ($diarios as $diario) {
            if ($diario->miembro_id) {
                $samples[] = $this->text2vector($diario->detalle);
                $labels[] = $diario->miembro_id;
            }
        }
        $this->classifier->train($samples, $labels);

        $modelManager = new ModelManager();
        $modelManager->saveToFile($this->classifier, $this->filepath);
        file_put_contents($this->filepath . '.json', json_encode($this));
    }

    public function predict($text)
    {
        $vector = $this->text2vector($text);
        return $this->classifier->predict($vector);
    }

    private function text2vector($text)
    {
        $words = $this->description2vector($text);
        $mat = [];
        $cero = $this->getVectorMiembro();
        foreach ($words as $w) {
            if (isset($this->valores[$w])) {
                $mat[] = $this->valores[$w];
            }
        }
        return $this->mat2vec([$cero, $this->mat2vec($mat, count($mat))]);
    }

    private function description2vector($description)
    {
        $words = preg_split($this->regexp, $this->normal($description));
        array_walk($words, function (&$word) {
            if (!in_array($word, $this->tokens)) {
                $this->tokens[] = $word;
            }
            $word = array_search($word, $this->tokens);
        });
        return $words;
    }

    private function normal($text)
    {
        $text = mb_strtolower($text);
        $patterns[0] = '/[á|â|à|å|ä]/';
        $patterns[1] = '/[ð|é|ê|è|ë]/';
        $patterns[2] = '/[í|î|ì|ï|y]/';
        $patterns[3] = '/[ó|ô|ò|ø|õ|ö]/';
        $patterns[4] = '/[ú|û|ù|ü]/';
        $patterns[5] = '/æ/';
        $patterns[6] = '/[çk]/';
        $patterns[7] = '/ß/';
        $replacements[0] = 'a';
        $replacements[1] = 'e';
        $replacements[2] = 'i';
        $replacements[3] = 'o';
        $replacements[4] = 'u';
        $replacements[5] = 'ae';
        $replacements[6] = 'c';
        $replacements[7] = 'ss';
        
        return (preg_replace($patterns, $replacements, $text));
    }

    private function getVectorMiembro($miembro_id = 0)
    {
        static $size;
        $size = $size ?? Miembro::count();
        $array = array_fill(0, $size, 0);
        $miembro_id && $array[$miembro_id - 1] = 1;
        return $array;
    }

    private function mat2vec($mat, $c = 1)
    {
        $sum = [];
        foreach ($mat as $a) {
            foreach ($a as $i => $ai) {
                $sum[$i] = ($sum[$i] ?? 0) + $ai / $c;
            }
        }
        return $sum;
    }
}
