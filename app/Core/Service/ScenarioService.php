<?php

namespace App\Core\Service;

use App\EpisodeAction;
use App\Game;
use App\Quest;
use Auth;

class ScenarioService
{

    const LOGIC_STATEMENT_ON_SCREEN_VARIABLE = 'logic_data_variable_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_ASSIGNMENT = 'logic_data_assignment_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_IF = 'logic_data_if_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_ELSEIF = 'logic_data_elseif_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_ELSE = 'logic_data_else_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_RIGHT_BRACKET = 'logic_data_right_bracket_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_LEFT_BRACKET = 'logic_data_left_bracket_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_RIGHT_BRACE = 'logic_data_right_brace_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_LEFT_BRACE = 'logic_data_left_brace_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_END_OF_OPERATOR = 'logic_data_end_of_operator_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_PLUS = 'logic_data_plus_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_MINUS = 'logic_data_minus_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_MULTIPLICATION = 'logic_data_multiplication_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_DIVISION = 'logic_data_division_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_PLUS_EQUAL = 'logic_data_plus_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_MINUS_EQUAL = 'logic_data_minus_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_MULTIPLICATION_EQUAL = 'logic_data_multiplication_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_DIVISION_EQUAL = 'logic_data_division_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_EQUAL = 'logic_data_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_NOT_EQUAL = 'logic_data_not_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_AND = 'logic_data_and_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_OR = 'logic_data_or_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_NOT = 'logic_data_not_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_GREATER = 'logic_data_greater_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_GREATER_OR_EQUAL = 'logic_data_greater_or_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_LOWER = 'logic_data_lower_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_LOWER_OR_EQUAL = 'logic_data_lower_or_equal_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_VALUE = 'logic_data_value_on_screen';
    const LOGIC_STATEMENT_ON_SCREEN_INDENT = 'logic_data_indent_on_screen';

    protected function getLogicStatementInterpretations()
    {
        return [
            self::LOGIC_STATEMENT_ON_SCREEN_VARIABLE => '${var_name}',
            self::LOGIC_STATEMENT_ON_SCREEN_ASSIGNMENT => '=',
            self::LOGIC_STATEMENT_ON_SCREEN_IF => 'if',
            self::LOGIC_STATEMENT_ON_SCREEN_ELSEIF => 'elseif',
            self::LOGIC_STATEMENT_ON_SCREEN_ELSE => 'else',
            self::LOGIC_STATEMENT_ON_SCREEN_RIGHT_BRACKET => ')',
            self::LOGIC_STATEMENT_ON_SCREEN_LEFT_BRACKET => '(',
            self::LOGIC_STATEMENT_ON_SCREEN_END_OF_OPERATOR => ';',
            self::LOGIC_STATEMENT_ON_SCREEN_PLUS => '+',
            self::LOGIC_STATEMENT_ON_SCREEN_MINUS => '-',
            self::LOGIC_STATEMENT_ON_SCREEN_MULTIPLICATION => '*',
            self::LOGIC_STATEMENT_ON_SCREEN_DIVISION => '/',
            self::LOGIC_STATEMENT_ON_SCREEN_PLUS_EQUAL => '+=',
            self::LOGIC_STATEMENT_ON_SCREEN_MINUS_EQUAL => '-=',
            self::LOGIC_STATEMENT_ON_SCREEN_MULTIPLICATION_EQUAL => '*=',
            self::LOGIC_STATEMENT_ON_SCREEN_DIVISION_EQUAL => '/=',
            self::LOGIC_STATEMENT_ON_SCREEN_EQUAL => '==',
            self::LOGIC_STATEMENT_ON_SCREEN_NOT_EQUAL => '!=',
            self::LOGIC_STATEMENT_ON_SCREEN_AND => '&&',
            self::LOGIC_STATEMENT_ON_SCREEN_OR => '||',
            self::LOGIC_STATEMENT_ON_SCREEN_NOT => '!',
            self::LOGIC_STATEMENT_ON_SCREEN_GREATER => '>',
            self::LOGIC_STATEMENT_ON_SCREEN_GREATER_OR_EQUAL => '>=',
            self::LOGIC_STATEMENT_ON_SCREEN_LOWER => '<',
            self::LOGIC_STATEMENT_ON_SCREEN_LOWER_OR_EQUAL => '<=',
            self::LOGIC_STATEMENT_ON_SCREEN_VALUE => '{value}',
        ];
    }

    public function isValidQuest($questId)
    {
        $valid = true;
        $quest = Quest::find($questId);
        $episodes = $quest->episodes;

        /**
         * Checking step 1: Quest must contain the start and finish episodes
         */
        $hasStartEpisode = count($episodes->filter(function ($episode) {
                return $episode->type == EpisodeService::EPISODE_TYPE_START;
            })) > 0;
        $hasFinishEpisode = count($episodes->filter(function ($episode) {
                return $episode->type == EpisodeService::EPISODE_TYPE_FINISH;
            })) > 0;

        if (!$hasStartEpisode || !$hasFinishEpisode) {
            $valid = false;
        }

        /**
         * Checking step 2: All episode actions should refer to other episodes
         */
        if ($valid) {
            foreach ($episodes as $episode) {
                foreach ($episode->episodeActions as $episodeAction) {
                    if ($episode->type == EpisodeService::EPISODE_TYPE_FINISH) {
                        continue;
                    }
                    if (!$episodeAction->target_episode_id) {
                        $valid = false;
                        break;
                    }
                    if (!$valid) {
                        break;
                    }
                }
            }
        }

        return $valid;
    }

    public function initiateGame($questId)
    {
        if (Auth::check()) {
            $alreadyStarted = Game::where('quest_id', $questId)
                ->where('user_id', Auth::user()->id)
                ->count();

            if (!$alreadyStarted) {
                Game::create([
                    'quest_id' => $questId,
                    'user_id' => Auth::user()->id,
                    'finished' => false,
                ]);
            }
        }
    }

    public function finishGame($questId)
    {
        if (Auth::check()) {
            Game::where('quest_id', $questId)
                ->where('user_id', Auth::user()->id)
                ->delete();
        }
    }

    public function isValidContainerLogic($episodeActionId = false, $questId = false)
    {
        if (!$episodeActionId && $questId) {
            $quest = Quest::find($questId);
            $baseLogic = $quest->init_logic;
        } elseif ($episodeActionId && !$questId) {
            $episodeAction = EpisodeAction::find($episodeActionId);
            $baseLogic = $episodeAction->logic;
        } else {
            return false;
        }
        $baseLogic = preg_replace('/<span class=("|"([^"]*)\s)var_label("|\s([^"]*)")>VAR<\/span>/', "", $baseLogic);
        $logicWithoutTrashTags = strip_tags($baseLogic, '<span><input>');
        preg_match_all('/<span.*?<\/span>/', $logicWithoutTrashTags, $logicStatementsList);
        $logicStatementsList = $logicStatementsList[0];

        $code = '';

        foreach ($logicStatementsList as $logicStatement) {
            preg_match_all('/logic_data.*_on_screen/', $logicStatement, $logicStatementType);
            $logicStatementType = $logicStatementType[0][0];

            switch ($logicStatementType) {
                case self::LOGIC_STATEMENT_ON_SCREEN_VALUE:
                    $code .= preg_replace(['/<span.*value=\"/', '/".*$/'], "", $logicStatement);
                    break;
                case self::LOGIC_STATEMENT_ON_SCREEN_VARIABLE:
                    $code .= '$' . preg_replace(['/<span.*value=\"/', '/".*$/'], "", $logicStatement);
                    break;
                case self::LOGIC_STATEMENT_ON_SCREEN_INDENT:
                    break;
                default:
                    $code .= strtolower(strip_tags($logicStatement));
                    break;
            }
        }

        $filePath = tempnam('/tmp', 'lc_');
        file_put_contents($filePath . '.php', "<?php\n" . htmlspecialchars_decode($code));
        $output = shell_exec('php -l ' . $filePath . '.php');
        unlink($filePath);
        unlink($filePath . '.php');

        if (strpos($output, 'parsing')) {
            return false;
        } else {
            return true;
        }
    }
}