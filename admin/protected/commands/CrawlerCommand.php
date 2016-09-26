<?php


class SystemCommand extends Command
{

    // @TODO: Decrease Cyclomatic complexity, NPath complexity
    public function actionParseMusicMama()
    {
        $mode = 'promo';
        $config = array(
            'promo' => array('link' => 'org', 'contact' => '���������� ����:'),
            'place' => array('link' => 'place', 'contact' => '���-��������:')
        );
        $result = array();

        try {
            $dom = new DomDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTMLFile(__DIR__ . '/' . $mode . '.html');
            libxml_clear_errors();
            $promo_urls = $dom->getElementsByTagName('a');
        } catch (Exception $e) {
            echo '[ERROR] Can\'t parse data from file' . PHP_EOL;
            return -1;
        }

        $context = stream_context_create(array('http' => array('ignore_errors' => true)));
        for ($i = $promo_urls->length; --$i >= 0;) {
            $result[$i] = array('name' => null, 'email' => null, 'tel' => null, 'contact' => null);

            $promo_el = $promo_urls->item($i);
            $promo_name = $promo_el->nodeValue;
            $promo_link = $promo_el->getAttribute('href');

            if (strstr($promo_link, $config[$mode]['link'])) {
                try {
                    $promo_email_page = file_get_contents($promo_link, false, $context);
                } catch (Exception $e) {
                    echo '[ERROR] Can\'t get data from ' . $promo_link . PHP_EOL;
                    continue;
                }

                $dom = new DomDocument();
                libxml_use_internal_errors(true);
                $promo_email_page = mb_convert_encoding($promo_email_page, 'HTML-ENTITIES', 'UTF-8');
                @$dom->loadHTML($promo_email_page);
                libxml_clear_errors();

                $promo_email_name = $dom->getElementsByTagName('h1');
                $promo_header_name = $promo_email_name->item(0);
                $result[$i]['name'] = $promo_header_name ?
                    $promo_header_name->nodeValue : str_replace('...', '', $promo_name);

                $promo_email_urls = $dom->getElementsByTagName('a');
                for ($j = $promo_email_urls->length; --$j >= 0;) {
                    $promo_email_el = $promo_email_urls->item($j);
                    $promo_email_link = $promo_email_el->getAttribute('href');

                    if (strstr($promo_email_link, 'mailto:') && $promo_email_link != 'mailto:hello@musicmama.ru') {
                        $result[$i]['email'] = trim(str_replace('mailto:', '', $promo_email_link));
                    }

                    if (strstr($promo_email_link, 'tel:')) {
                        $result[$i]['tel'] = trim(str_replace('tel:', '', $promo_email_link));
                    }
                }

                $promo_email_lis = $dom->getElementsByTagName('li');
                for ($k = $promo_email_lis->length; --$k >= 0;) {
                    $promo_email_li = $promo_email_lis->item($k);
                    $promo_email_cc = strip_tags($promo_email_li->nodeValue);
                    if (strstr($promo_email_cc, $config[$mode]['contact'])) {
                        $result[$i]['contact'] = trim(str_replace($config[$mode]['contact'], '', $promo_email_cc));
                    }
                }
            }
        }

        $csv = '';
        foreach ($result as $row) {
            if (!empty($row)) {
                $csv .= '"' . implode('","', $row) . '"' . "\n";
            }
        }

        file_put_contents($mode . '.csv', $csv);
        return 0;
    }

    public function actionGrabVipBooking()
    {
        $mode = 'agencies';
        try {
            $dom = new DomDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTMLFile(__DIR__ . '/' . $mode . '.html');
            libxml_clear_errors();
            $urls = $dom->getElementsByTagName('a');
        } catch (Exception $e) {
            echo '[ERROR] Can\'t parse data from file' . PHP_EOL;
            return -1;
        }

        $context = stream_context_create(
            array(
                'http'  => array(
                    'method'        => "GET",
                    'ignore_errors' => true,
                    'header'        => "Accept-language: en\r\n" .
                        "Cookie: .ASPXAUTH=2E5A55C89174FECE67C7B27935C72AA3158CC13AA5AFEF5302F38F01C58D8D71276C140E4A0
                        771C38D5DEEAC3C6ED4516CA35CD94EF663A69568ACEB9B7285F81140CCC27F92C8265B577512B40077C199F011865
                        56612BF1D2BFF359DB1E6EDF516DE44D8A98CC1E11D6C3DA79A9EC7740B7DDEAC6F1F5B7646B5784CB332AE;
                        ASP.NET_SessionId=hpfvkkod0r2cvnyn4ug3u2p5\r\n"
                ),

            )
        );

        for ($i = $urls->length; --$i >= 0;) {
            $element = $urls->item($i);
            $element_link = $element->getAttribute('href');
            if (strstr($element_link, 'details')) {
                try {
                    $element_page = file_get_contents($element_link, false, $context);
                    $element_id = str_replace('http://www.vip-booking.com/details?id=', '', $element_link);
                    file_put_contents('./' . $mode . '/' . $element_id . '.html', $element_page);
                } catch (Exception $e) {
                    echo '[ERROR] Can\'t get data from ' . $element_link . PHP_EOL;
                    continue;
                }
            }
        }
        return 0;
    }

    public function actionParseVipBooking()
    {
        $mode = 'agencies';
        $result = array();
        $directory = new DirectoryIterator(__DIR__ . '/' . $mode);
        foreach ($directory as $path) {
            if ($path->isFile()) {
                $item = $this->parsePage($path->getPathname());
                $result[] = $item;
            }
        }
        file_put_contents($mode . '.json', json_encode($result));
    }

    // @TODO: Decrease Cyclomatic complexity, NPath complexity
    private function parsePage($file_name)
    {
        $result = array();

        $dom = new DomDocument();
        libxml_use_internal_errors(true);
        @$dom->loadHTMLFile($file_name);
        libxml_clear_errors();

        $finder = new DomXPath($dom);

        $title = $dom->getElementById('title');
        $result['title'] = trim($title->nodeValue);

        $desc = $dom->getElementById('desc');
        $result['desc'] = trim(str_replace('(', '', str_replace(')', '', $desc->nodeValue)));

        echo 'Processing ' . $result['title'] . PHP_EOL;

        $class_name = 'cap-case';
        $info = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class_name ')]");
        foreach ($info as $item) {
            $index = 1;
            $label = '';
            $rows = $item->getElementsByTagName('td');
            foreach ($rows as $row) {
                if ($index % 2 != 0) {
                    $label = trim(strtolower(str_replace(':', '', $row->nodeValue)));
                } else {
                    $result[$label] = trim($row->nodeValue);
                }
                $index++;
            }
        }

        $index = 1;
        $class_name = 'staff-item';
        $staff = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class_name ')]");
        foreach ($staff as $item) {
            $staff_dom = new DOMDocument;
            @$staff_dom->loadHTML($dom->saveHTML($item));
            $sub_finder = new DomXPath($staff_dom);

            try {
                $class_name = 'staff-name';
                $staff_name = $sub_finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class_name ')]");
                $staff_name = $staff_name->item(0)->getElementsByTagName('a')->item(0);
                $result['staff-' . $index . '-name'] = $staff_name ? trim($staff_name->nodeValue) : 'Not Found';
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
                unset($result['staff-' . $index . '-name']);
                continue;
            }

            try {
                $class_name = 'staff-position';
                $staff_position = $sub_finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class_name ')]");
                $staff_position = trim($staff_position->item(0)->nodeValue);
                $result['staff-' . $index . '-position'] = str_replace('(', '', str_replace(')', '', $staff_position));
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
                unset($result['staff-' . $index . '-name']);
                unset($result['staff-' . $index . '-position']);
                continue;
            }

            try {
                $class_name = 'staff-email';
                $staff_email = $sub_finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $class_name ')]");
                $staff_email = $staff_email->item(0)->getElementsByTagName('a')->item(0);
                $result['staff-' . $index . '-email'] = $staff_email ? trim(str_replace('mailto:', '', $staff_email->getAttribute('href'))) : 'Not Found';
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
                unset($result['staff-' . $index . '-name']);
                unset($result['staff-' . $index . '-position']);
                unset($result['staff-' . $index . '-email']);
                continue;
            }
            $index++;
        }

        return $result;
    }

    public function actionImportArtists()
    {
        $data = array(
            array(
                'base' => 'http://www.residentadvisor.net',
                'fbex' => 'facebook.com/residentadvisor',
                'link' => 'http://www.residentadvisor.net/dj.aspx',
                'sign' => 'dj'
            ),
            array(
                'base' => 'http://www.residentadvisor.net',
                'fbex' => 'facebook.com/residentadvisor',
                'link' => 'http://www.residentadvisor.net/dj-100.aspx',
                'sign' => 'dj'
            ),
            array(
                'base' => 'http://www.residentadvisor.net',
                'fbex' => 'facebook.com/residentadvisor',
                'link' => 'http://www.residentadvisor.net/dj.aspx?country=12',
                'sign' => 'dj'
            ),
            array(
                'base' => 'http://www.residentadvisor.net',
                'fbex' => 'facebook.com/residentadvisor',
                'link' => 'http://www.residentadvisor.net/dj.aspx?country=3',
                'sign' => 'dj'
            ),
            array(
                'base' => 'http://www.residentadvisor.net',
                'fbex' => 'facebook.com/residentadvisor',
                'link' => 'http://www.residentadvisor.net/dj.aspx?country=2',
                'sign' => 'dj'
            ),
            array(
                'base' => 'http://www.residentadvisor.net',
                'fbex' => 'facebook.com/residentadvisor',
                'link' => 'http://www.residentadvisor.net/dj.aspx?country=6',
                'sign' => 'dj'
            ),
            array(
                'base' => 'http://www.residentadvisor.net',
                'fbex' => 'facebook.com/residentadvisor',
                'link' => 'http://www.residentadvisor.net/dj.aspx?country=15',
                'sign' => 'dj'
            ),
        );

        foreach ($data as $item) {
            $this->actionImportArtistsFromRA($item);
        }
    }

    // @TODO: Decrease Cyclomatic complexity, NPath complexity
    // @TODO: Split method for submethods, decrease the number of lines
    public function actionImportArtistsFromRA($batch_data)
    {
        if (!$access_token = $this->_getAccessToken()) {
            return -1;
        }

        $count = 0;
        $fb_ids = array();
        $artist_aliases = array();
        $artists = Artist::model()->findAll('fb_id > 0');
        foreach ($artists as $artist) {
            $fb_ids[] = $artist->fb_id;
            $artist_aliases[] = $artist->alias;
        }

        // Get RA TOP1000 page
        try {
            $artist_list_page = file_get_contents($batch_data['link'], false, $this->_context());
        } catch (Exception $e) {
            echo '[ERROR] Can\'t get data from ' . $batch_data['link'] . PHP_EOL;
            echo '[E' . $e->getCode() . '] ' . $e->getMessage();
            return -1;
        }

        try {
            $dom = new DomDocument();
            libxml_use_internal_errors(true);
            @$dom->loadHTML($artist_list_page);
            libxml_clear_errors();
            $artist_list_urls = $dom->getElementsByTagName('a');
        } catch (Exception $e) {
            echo '[ERROR] Can\'t parse data from ' . $batch_data['link'] . PHP_EOL;
            echo '[E' . $e->getCode() . '] ' . $e->getMessage();
            return -1;
        }

        // Process links on TOP1000 page
        echo 'Found ' . $artist_list_urls->length . ' links on ' . $batch_data['link'] . PHP_EOL;
        for ($i = $artist_list_urls->length; --$i >= 0;) {
            $artist_list_el = $artist_list_urls->item($i);
            $artist_name = $artist_list_el->nodeValue;
            $artist_alias = Model::createAlias($artist_name);
            $artist_link = $artist_list_el->getAttribute('href');

            // If this link routes to Artist
            if (strstr($artist_link, $batch_data['sign']) && !in_array($artist_alias, $artist_aliases)) {
                $artist_page = file_get_contents($batch_data['base'] . $artist_link, false, $context);

                $dom = new DomDocument();
                $dom->loadHTML($artist_page);
                $artist_urls = $dom->getElementsByTagName('a');

                // Process links on artist page
                $fb_links = 0;
                for ($j = $artist_urls->length; --$j >= 0;) {
                    $artist_el = $artist_urls->item($j);
                    $artist_fb_link = $artist_el->getAttribute('href');

                    // Found link to facebook
                    if (strstr($artist_fb_link, 'facebook.com') && !strstr($artist_fb_link, $batch_data['fbex'])) {
                        $fb_links++;

                        // Try to get Facebook id by link
                        try {
                            $graph_link = str_replace('http://www', 'https://graph', $artist_fb_link);
                            $fb_graph_data = file_get_contents(trim($graph_link), false, $context);
                            $fb_graph_data = \CJSON::decode($fb_graph_data);
                        } catch (Exception $e) {
                            echo '[WARNING] Cant get graph data from Facebook for ' . $artist_name . PHP_EOL;
                            echo '[E' . $e->getCode() . '] ' . $e->getMessage() . PHP_EOL;
                            continue;
                        }

                        // Trying add artist
                        if (isset($fb_graph_data['id']) && !in_array($fb_graph_data['id'], $fb_ids)) {
                            if ($this->addArtistFromFacebook($artist_name, $fb_graph_data)) {
                                $fb_ids[] = $fb_graph_data['id'];
                                $count++;
                            } else {
                                echo '[WARNING] Cant save artist ' . $artist_name . ' to DB' . PHP_EOL;
                                $this->_printErrors($this->errors);
                            }
                        }
                    }
                }

                // If no Facebook links found on RA artist page
                if (!$fb_links) {
                    // echo '[NOTICE] Facebook link for ' . $artist_name . ' not found' . PHP_EOL;
                    if ($artist_name) {
                        // Trying to search it by name on Facebook
                        try {
                            $fb_search_data = file_get_contents('https://graph.facebook.com/search?q=' . urlencode($artist_name) . '&type=page&' . $access_token, false, $context);
                            $fb_search_data = \CJSON::decode($fb_search_data);

                            if (isset($fb_search_data['data']) && count($fb_search_data['data']) && isset($fb_search_data['data'][0]['id'])) {
                                $fb_graph_data = file_get_contents('https://graph.facebook.com/' . $fb_search_data['data'][0]['id'], false, $context);
                                $fb_graph_data = \CJSON::decode($fb_graph_data);

                                // Trying add artist
                                if (isset($fb_graph_data['id']) && !in_array($fb_graph_data['id'], $fb_ids)) {
                                    if ($this->addArtistFromFacebook($artist_name, $fb_graph_data)) {
                                        $fb_ids[] = $fb_graph_data['id'];
                                        $count++;
                                    } else {
                                        echo '[WARNING] Cant save artist ' . $artist_name . ' to DB' . PHP_EOL;
                                        $this->_printErrors($this->errors);
                                    }
                                }
                            } else {
                                echo '[NOTICE] Artist ' . $artist_name . ' not found by graph search' . PHP_EOL;
                            }
                        } catch (Exception $e) {
                            echo '[WARNING] Can\'t find ' . $artist_name . ' on FB' . PHP_EOL;
                            echo '[E' . $e->getCode() . '] ' . $e->getMessage() . PHP_EOL;
                        }
                    }
                }
            }
        }

        echo 'Imported artists ' . $count . PHP_EOL;
        return 0;
    }

    // @TODO: Decrease Cyclomatic complexity
    private function addArtistFromFacebook($name, $data)
    {
        $artist = new Artist;
        $transaction = $artist->dbConnection->beginTransaction();

        // Defaults
        $latitude = User::getDefaultLatitude();
        $longitude = User::getDefaultLongitude();
        $description = '';

        if (isset($data['location'])) {
            $latitude = $data['location']['latitude'];
            $longitude = $data['location']['longitude'];
            $description = $data['location']['country'] . ', ' . $data['location']['city'];
        } else {
            $address = '';

            if (isset($data['current_location'])) {
                $address = $data['current_location'];
            } elseif (isset($data['hometown'])) {
                $address = $data['hometown'];
            }

            try {
                $address = file_get_contents('http://maps.google.com/maps/api/geocode/json?sensor=false&address=' . urlencode($address));
                $address = \CJSON::decode($address);
            } catch (Exception $e) {
                $address = array('status' => 'ERROR');
            }

            if ($address['status'] == 'OK') {
                $geometry = $address['results'][0]['geometry'];
                $latitude = $geometry['location']['lat'];
                $longitude = $geometry['location']['lng'];
                $description = $address['results'][0]['formatted_address'];
            }
        }

        $artist->attributes = array(
            'name' => $name,
            'fb_id' => $data['id'],
            'latitude' => $latitude,
            'longitude' => $longitude,
            'description' => $description,
            'ds_type' => DataSource::FACEBOOK
        );

        $email = '';
        if (isset($data['email'])) {
            $email = $data['email'];
        } elseif (isset($data['general_manager'])) {
            $email = $this->_extractFirstEmail($data['general_manager']);
        } elseif (isset($data['booking_agent'])) {
            $email = $this->_extractFirstEmail($data['booking_agent']);
        }

        if (!$email && isset($data['username'])) {
            $email = $data['username'] . '@boogi.co';
        } else {
            $email = Model::createAlias($name) . '@boogi.co';
        }

        $artist->bindRelatedParams(array(
            'email' => $email,
            'password' => 'starway2014',
            'role' => USER::ROLE_ARTIST,
        ));

        try {
            if ($artist->save()) {
                $transaction->commit();
                echo '[NOTICE] Artist ' . $name . ' added to DB' . PHP_EOL;
                return true;
            } else {
                $transaction->rollback();
                $this->errors = $artist->getErrors();
                return false;
            }
        } catch (Exception $e) {
            $transaction->rollback();
            echo '[NOTICE] ' . $e->getCode() . ' ' . $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    private function _getAccessToken()
    {
        $fbAppId = Yii::app()->params['fbAppId'];
        $fbSecret = Yii::app()->params['fbSecret'];

        try {
            $data_url = 'https://graph.facebook.com/oauth/access_token?client_id=' .
                $fbAppId . '&client_secret=' . $fbSecret . '&grant_type=client_credentials';
            return file_get_contents($data_url, false, $this->_context());
        } catch (Exception $e) {
            Command::log($e->getMessage(), CLogger::LEVEL_ERROR, __CLASS__);
            return 0;
        }
    }
}
