<?php

namespace App\Helpers;

use App\Models\Group;
use voku\helper\HtmlDomParser;

class Parser
{

    /**
     * @param HtmlDomParser $content
     * @return Group[]
     */
    public static function parseGroups(HtmlDomParser $content): array
    {
        $groups = Group::all();
        $created_groups = [];
        $accordion = $content->find('div[id=raspStructure]', 0);

        # Перебор институтов
        foreach ($accordion->children() as $fac) {
            $facName = trim($fac->find('.card-header', 0)->text());

            # перебор групп
            foreach ($fac->find('a') as $group) {
                $groupName = trim($group->text());
                $url = trim(explode("group/", $group->getAttribute('href'))[1]);
                $group = $groups->firstWhere('name', $groupName);

                if ($group === null) {
                    try {
                        $group_data = [
                            'name' => $groupName,
                            'faculty' => $facName,
                            'url' => $url
                        ];

                        $group = Group::create($group_data);
                        $created_groups[] = $group;
                        $groups->push($group);
                    } catch (Exception $error) {
                        echo $error->getMessage(), PHP_EOL;
                    }
                } elseif ($url != $group->url) {
                    try {
                        $group->url = $url;
                        $group->save();
                    } catch (Exception $error) {
                        echo $error->getMessage(), PHP_EOL;
                    }
                }
            }
        }
        return $created_groups;
    }
}