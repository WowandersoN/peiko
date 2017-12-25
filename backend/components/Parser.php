<?php

namespace backend\components;



use yii\base\Component;
use yii\base\ErrorException;

class Parser extends Component
{

    public function parse($url, $cssClass = '') {
        //Получаем код фида
        $rssCode = static::parseCode($url);
        foreach ($rssCode as $key => $oneRssCode) {
            //Удаляем html теги, кроме <br> и <a>
            $textDeleteHtmlTags = static::deleteHtmlTags($oneRssCode['description']);
            //Изменяем коды ссылок, добавляя в них rel="nofollow", target="_blank" и css класс, если он был указан
            $textUpdateExternalLink = static::convertCodeExternalLinks($textDeleteHtmlTags, $cssClass);
            //Разделяем описание на параграфы
            $devideText = static::devideTextByTag($textUpdateExternalLink);
            //Заменяем в полученных данных старое описание на новое
            $rssCode[$key]['description'] = $devideText;
        }

        return $rssCode;
    }

    public static function parseCode($url) {
        $domDoc = new \DOMDocument;
        //Загружаем фид
        try {
            $loadFlag = $domDoc->load($url);
        } catch(ErrorException $e) {
            throw new ErrorException("Ошибка системы");
        }
        //Если не произошла ошибка при получении контента фида
        if($loadFlag === true) {
            //Получаем списки новостей
            $items = $domDoc->getElementsByTagName('item');
            //Пробегаем каждую новость
            foreach($items as $codeOneItem) {
                //Получаем title
                $newsTitleObject = $codeOneItem->getElementsByTagName('title');
                $titleText = $newsTitleObject->item(0)->nodeValue;
                $title = htmlspecialchars($titleText);
                //Получаем description
                $newsDescriptionObject = $codeOneItem->getElementsByTagName('description');
                $description = htmlspecialchars($newsDescriptionObject->item(0)->nodeValue);
                //Получаем айдишник новости
                $newsGuidObject = $codeOneItem->getElementsByTagName('guid');
                $guid = htmlspecialchars($newsGuidObject->item(0)->nodeValue);
                //Получаем картинку
                $newsImageObject = $codeOneItem->getElementsByTagName('image');
                if($newsImageObject->item(0)){
                    $image = htmlspecialchars($newsImageObject->item(0)->nodeValue);
                }else{
                    $image = '';
                }
                //Получаем дату публикации новости
                $newsDateObject = $codeOneItem->getElementsByTagName('pubDate');
                $publicationDate = htmlspecialchars($newsDateObject->item(0)->nodeValue);
                $date = new \DateTime(trim($publicationDate));
                $publicationDate = $date->getTimestamp();
                $rssData[] = [
                    'title' => $title,
                    'description' => $description,
                    'publicationDate' => $publicationDate,
                    'guid' => $guid,
                    'image' => $image,
                ];
            }
            unset($url, $domDoc, $loadFlag, $items, $newsTitleObject, $titleText, $title, $newsDescriptionObject, $description);
            unset($newsLinkObject, $link, $newsDateObject, $codeOneItem, $publicationDate, $explodeDate, $day, $month, $year);
            unset($explodeTime, $hours, $minuts, $seconds, $publicationDate);
            return $rssData;
        } else {
            throw new ErrorException("Произошла ошибка при чтении RSS файла");
        }
    }
    /**
     * Разделение текста по тегу <br>, чтобы получить массив с параграфами
     *
     * @param string $data текст, подлежащий обработке
     * @return array Нумерованный массив, где каждый элемент является одним текстовым параграфом
     * @access public
     * @static
     */
    public static function devideTextByTag($data) {
        //Разделяем текст по тегам
        $devidedText = $data;
        $explodeText = preg_split("/&lt;br.*&gt;/isU", $data, -1, PREG_SPLIT_NO_EMPTY);
        //Пробегаем каждую получившуюсячасти
        foreach($explodeText as $onePartText) {
            //Удаляем пробелы
            $onePartText = trim($onePartText);
            if($onePartText !== '') {
                //Сохраняем текст в массив
                $devidedText[] = $onePartText;
            }
        }
        unset($data, $dataType, $explodeText, $onePartText);

        return $devidedText;
    }

    public static function deleteHtmlTags($data) {
        //Удаляем все теги, кроме двух указанных
        $clearData = strip_tags(html_entity_decode($data), '<a><br>');

        unset($dataType);
        return htmlspecialchars($clearData);
    }

    public static function convertCodeExternalLinks($data, $cssClass)
    {
        $urlTags = '';
        //Получаем ссылки
        $numberFindedUrlTags = preg_match_all("/&lt;a.*\/a&gt;/isU", $data, $urlTags);
        if(($numberFindedUrlTags !== 0) && ($numberFindedUrlTags !== false)) {
            //Пробегаем все найденные ссылки
            for($j = 0; $j < $numberFindedUrlTags; $j++) {
                $codeWithUrl = '';
                $urlDescription = '';
                //Получаем саму ссылку из кода со ссылкой
                $findCodeUrlInUrlTags = preg_match("/href.*(&quot;|&#039;).*(&quot;|&#039;)/isU", $urlTags[0][$j], $codeWithUrl);
                //Получаем описание из ссылки
                $findDescriptionUrlInUrlTags = preg_match("/&gt;.*&lt;/isU", $urlTags[0][$j], $urlDescription);
                //Если нашли ссылки в кодах ссылок и не было ошибок при поиске
                if(($findCodeUrlInUrlTags !== 0)
                    && ($findDescriptionUrlInUrlTags !== 0)
                    && ($findCodeUrlInUrlTags !== false)
                    && ($findDescriptionUrlInUrlTags !== false)) {
                    //Очищаем код со ссылкой
                    $clearUrl = preg_replace("/href|=|&quot;|&#039;/isU", '', $codeWithUrl[0]);
                    //очищаем описание
                    $clearDescription = preg_replace("/\/|&lt;|&gt;/isU", '', $urlDescription[0]);
                    //Если было указано имя CSS класса, который нужно привязать ссылке
                    if($cssClass !== '') {
                        $cssClassCode = 'class=&quot;'.$cssClass.'&quot;';
                    } else {
                        $cssClassCode = '';
                    }
                    //Форимруем новый код ссылки
                    $newUrl = '&lt;a href=&quot;'.$clearUrl.'&quot; '.$cssClassCode.' target=&quot;_blanck&quot; rel=&quot;nofollow&quot;&gt;'.$clearDescription.'&lt;/a&gt;';
                    //Экранируем код со ссылкой, чтобы его можно использовать в регулярке далее
                    $quoteUrlCode = preg_quote($urlTags[0][$j], '/');
                    //Переделываем описание ссылки в нижний регистр
                    $lowerClearDescription = mb_strtolower($clearDescription, 'UTF-8');
                    //Есть нет указанного слова, знаичт скорее всего это сслыка не типа "читать далее"
                    if(strpos($lowerClearDescription, 'читать') === false) {
                        //Заменяем старый код ссылки на новый
                        $data = preg_replace("/$quoteUrlCode/isU", $newUrl, $data);
                    } else {
                        //Заменяем ссылку на пустое
                        $data = preg_replace("/$quoteUrlCode/isU", '', $data);
                    }
                }
            }
            unset($cssClass, $urlTags, $numberFindedUrlTags, $j, $codeWithUrl, $urlDescription, $findCodeUrlInUrlTags);
            unset($findDescriptionUrlInUrlTags, $clearUrl, $clearDescription, $cssClassCode, $newUrl, $quoteUrlCode);
            return $data;
        } else { //Если ссылок не нашлось или произошла ошибка
            if($numberFindedUrlTags === false) {
                throw new ErrorException("Ошибка системы");
            }
            //Усли не нашли внешние ссылки
            if($numberFindedUrlTags === 0) {
                unset($cssClass, $urlTags, $numberFindedUrlTags);
                return $data;
            }
        }
    }

}