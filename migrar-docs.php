<?php
    $fichero = file_get_contents('file:///Users/wsandoval/Downloads/do3op_posts.json');
    $post_meta = file_get_contents('file:///Users/wsandoval/Downloads/do3op_postmeta.json');

    $reviews = file_get_contents('file:///Users/wsandoval/Downloads/do3op_reviews.json');
    $ratings = file_get_contents('file:///Users/wsandoval/Downloads/do3op_ratings.json');

    $json              =     json_decode($fichero);
    $json_meta         =     json_decode($post_meta);
    $json_reviews      =     json_decode($reviews);
    $json_ratings      =     json_decode($ratings);

    require_once("admin/models/Doctors.php");
    require_once("admin/models/DataDoctors.php");
    require_once("admin/models/CalificationDoctors.php");

    $doctors                  =     new Doctors();
    $data_doctors             =     new DataDoctors();
    $calification_doctors     =     new CalificationDoctors();

    $data             =     $json[2]->data;
    $data_meta        =     $json_meta[2]->data;
    $data_reviews     =     $json_reviews[2]->data;
    $data_ratings     =     $json_ratings[2]->data;

    foreach ($data as $post)
    {
        if ($post->post_type == 'site' && $post->post_status == 'publish' && $post->post_parent == 0)
        {
            $doctors->setClientId(1);
            $doctors->setName(addslashes($post->post_title));
            $doctors->setSubTitle(addslashes($post->post_excerpt));
            $doctors->setDescription(addslashes($post->post_content));
            $doctors->setPlanId(1);

            foreach ($data_meta as $post_son)
            {
                if ($post_son->meta_key == 'contact' && $post_son->post_id == $post->ID)
                {
                    $meta_value = unserialize($post_son->meta_value);

                    if (isset($meta_value["email"]["value"]))
                    {
                        $doctors->setEmail($meta_value["email"]["value"]);
                    }
                    else
                    {
                        $doctors->setEmail(" ");
                    }
                    
                    break;
                }
            }

            $photo_name = "";
            
            foreach ($data as $postInfo)
            {
                if ($postInfo->post_type == 'attachment' && $postInfo->post_parent == $post->ID)
                {
                    //Get the file
                    //$content = file_get_contents($postInfo->guid);

                    $photo_explode = explode("/", $postInfo->guid);
                    $photo_name = end($photo_explode);

                    //Store in the filesystem.
                    /*$fp = fopen("admin/img/doctors/".$photo_name, "w");
                    fwrite($fp, $content);
                    fclose($fp);*/

                    $doctors->setLogo($photo_name);
                }
            }

            if ($photo_name == "")
            {
                $doctors->setLogo(NULL);
            }

            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';

            for ($i = 0; $i < 4; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

            $doctors->setCode($randomString);

            $doctors->InsertDoctor();

            $lastDoctorId = $doctors->lastDoctorId();

            foreach ($data_meta as $post_son)
            {
                if ($post_son->meta_key == 'contact' && $post_son->post_id == $post->ID)
                {
                    $meta_value = unserialize($post_son->meta_value);

                    if (isset($meta_value["address"]["value"]))
                    {
                        $data_doctors->setDoctorId($lastDoctorId);
                        $data_doctors->setName("Dirección");
                        $data_doctors->setDescription($meta_value["address"]["value"]);
                        $data_doctors->CreateData();
                    }
                    if (isset($meta_value["phone"]["value"]))
                    {
                        $data_doctors->setDoctorId($lastDoctorId);
                        $data_doctors->setName("Teléfono");
                        $data_doctors->setDescription($meta_value["phone"]["value"]);
                        $data_doctors->CreateData();
                    }
                    if (isset($meta_value["website"]["value"]))
                    {
                        $data_doctors->setDoctorId($lastDoctorId);
                        $data_doctors->setName("Página Web");
                        $data_doctors->setDescription($meta_value["website"]["value"]);
                        $data_doctors->CreateData();
                    }

                    break;
                }
            }

            foreach ($data_reviews as $review)
            {
                if ($review->review_post_id == $post->ID)
                {
                    $calification_doctors->setDoctorId($lastDoctorId);
                    $calification_doctors->setNameUser($review->user_name);

                    foreach ($data_ratings as $rating)
                    {
                        if ($rating->review_id == $review->review_id)
                        {
                            $val = intval($rating->rating_value);
                            $count_stars;

                            if ($val > 0 && $val < 10)
                            {
                                $count_stars = 1;
                            }
                            elseif ($val > 10 && $val < 20)
                            {
                                $count_stars = 2;
                            }
                            elseif ($val > 20 && $val < 30)
                            {
                                $count_stars = 3;
                            }
                            elseif ($val > 30 && $val < 40)
                            {
                                $count_stars = 4;
                            }
                            elseif ($val > 40 && $val < 50)
                            {
                                $count_stars = 5;
                            }
                            elseif ($val == 50)
                            {
                                $count_stars = 5;
                            }
                            elseif ($val == 0)
                            {
                                $count_stars = 1;
                            }

                            $calification_doctors->setCountStars($count_stars);
                            break;
                        }
                    }

                    $calification_doctors->setEmail(" ");
                    $calification_doctors->setComment($review->review_content);
                    $calification_doctors->setDateComment($review->review_date);

                    if ($review->status == 0)
                    {
                        $calification_doctors->setStatus('Active');
                        $calification_doctors->setStatusDoctor('Active');
                    }
                    elseif ($review->status == 1)
                    {
                        $calification_doctors->setStatus('Active');
                        $calification_doctors->setStatusDoctor('Inactive');
                    }
                    else
                    {
                        $calification_doctors->setStatus('Inactive');
                        $calification_doctors->setStatusDoctor('Inactive');
                    }

                    $calification_doctors->InsertCalificationDoctor();
                }
            }
        }
        
    }
?>