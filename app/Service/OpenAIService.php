<?php

namespace App\Service;

use OpenAI;
use OpenAI\Client;

class OpenAIService
{
    protected OpenAI $openAI;
    private string $apiKey;
    private Client $openAIClient;

    public function __construct(OpenAI $openAI)
    {
        $this->openAI = $openAI;
        $this->apiKey = env('OPENAI_API_KEY');
        $this->openAIClient = $this->openAI->client($this->apiKey);
    }

    public function getNoteTitle(string $input): string
    {
        $systemContent = <<<HERE
Ты ассистент для программы, которая хранит технические заметки для IT специалиста.
Тебе передают сниппет кода или команду Линукс.
Составь краткий заголовок для переданной тебе информации на максимум 80 символов на русском
языке, но что бы было понятно о чем речь в заметке. Не концентируйся на деталях, опиши в заголовке суть.
Экономь символы в разумных пределах, например можно не ставить точку в конце заголовка.
Не повторяй то что тебе уже передано.
HERE;

        $result = $this->openAIClient->chat()->create([
            'model' => 'gpt-3.5-turbo-0125',
            'messages' => [
                ['role' => 'system', 'content' => $systemContent],
                ['role' => 'user', 'content' => $input],
            ],
        ]);
        logger()->info('Open AI result Title', [$result]);

        return $result->choices[0]->message->content;
    }

    public function getNoteContent(string $input): string
    {
        $systemContent = <<<HERE
Ты ассистент для программы, которая хранит технические заметки для IT специалиста.
Тебе передают заголовок заметки о том что должно быть в заметке. Составь ее на английском языке. Это должен быть только сниппет кода или команда
Линукс. Только код. Не нужно оформлять код кавычками или апострофами.
HERE;

        $result = $this->openAIClient->chat()->create([
            'model' => 'gpt-3.5-turbo-0125',
            'messages' => [
                ['role' => 'system', 'content' => $systemContent],
                ['role' => 'user', 'content' => $input],
            ],
        ]);
        logger()->info('Open AI result Content', [$result]);

        return $result->choices[0]->message->content;
    }
}
