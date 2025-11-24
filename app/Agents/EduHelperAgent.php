<?php

namespace App\Agents;

class EduHelperAgent
{
    protected array $allowedTopics = [
        'solar system',
        'fractions',
        'water cycle',
    ];


    public function reply(string $message): string
    {
        $msgLower = strtolower($message);


        $foundTopic = null;
        foreach ($this->allowedTopics as $topic) {
            if (str_contains($msgLower, $topic)) {
                $foundTopic = $topic;
                break;
            }
        }

        if (!$foundTopic) {
            return "I can only help with Solar System, Fractions, or Water Cycle for now 😊";
        }


        $answer = $this->localAnswer($foundTopic, $message);

        //  max 60 words
        $words = preg_split('/\s+/', trim($answer));
        if (count($words) > 60) {
            $answer = implode(' ', array_slice($words, 0, 60));
            $answer = rtrim($answer, " ,.;:") . '...';
        }

        // answer
        return "Hi! " . $answer;
    }

    protected function localAnswer(string $topic, string $message): string
    {
        $answers = [
            'solar system' => "The Solar System has the Sun at the centre and eight main planets orbit it: Mercury, Venus, Earth, Mars, Jupiter, Saturn, Uranus and Neptune. Many asteroids, comets and dwarf planets like Pluto also orbit the Sun.",
            'fractions' => "A fraction shows a part of a whole in the form numerator/denominator. Example: 1/2 means one of two equal parts. To add fractions, make denominators same, then add numerators and simplify.",
            'water cycle' => "The water cycle moves water through evaporation, condensation, precipitation and collection. Water evaporates into vapour, forms clouds (condensation), falls as rain (precipitation) and collects in oceans, lakes or soil.",
        ];

        return $answers[$topic] ?? '';
    }
}
