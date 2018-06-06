<?php

require_once 'reddit_bootstrap.php';
require_once '/data/db.php';

$at_id = preg_replace("@[^a-zA-Z0-9_\.-]@", "", (string) @$argv[1]);
$text = @$argv[2];
$original_text = $text;

if(!empty($original_text)){
    $post = $reddit_call('/api/comment', 'POST', [
        'api_type' => 'json',
        'thing_id' => $at_id,
        'text' => $text."\n\n---\n**casinocointipbot** 🎉 **[HOWTO](https://www.casinocointipbot.com/howto)** | [ACCOUNT](https://www.casinocointipbot.com/account) | [DEPOSIT](https://www.casinocointipbot.com/deposit) | [WITHDRAW](https://www.casinocointipbot.com/withdraw) | [STATS](https://www.casinocointipbot.com/stats)",
    ]);
}

if(empty($original_text) || !empty($post->json->data->things[0]->data->name) || (!empty($post->json->errors[0][0]) && preg_match("@delete@i", $post->json->errors[0][0]))){
    if(!empty($post->json->errors)){
        echo "\n\nProcessed, but WITH ERRORS: ";
        print_r($post->json->errors);
    }else{
        if(!empty($post->json->data->things[0]->data->name)){
            echo "\n\nPosted, " . @$post->json->data->things[0]->data->name . ' ^ ' . @$post->json->data->things[0]->data->parent_id . ' @ ' . @$post->json->data->things[0]->data->permalink . "\n";
        }else{
            if(empty($original_text)){
                echo "\n\nSuppressed, no text.\n";
            }else{
                echo "\n\nPosted\n";
            }
        }
    }
    $parent_id = $at_id;
    $permalink = @$post->json->data->things[0]->data->permalink;
    $id = @$post->json->data->things[0]->data->name;
    $reaction = $permalink . '#' . $id;
    try {
        $query = $db->prepare('UPDATE `message` SET `processed` = 1, processed_moment = CURRENT_TIMESTAMP, action = "reaction", reaction = :reaction WHERE `ext_id` = :ext_id AND `network` = "reddit" LIMIT 1');
        $query->bindValue(':ext_id', $parent_id);
        $query->bindValue(':reaction', $reaction);
        $query->execute();
    }
    catch (\Throwable $e) {
        echo "\n ERROR: " . $e->getMessage() . "\n";
    }
}else{
    echo "\n\nERROR\n";
    print_r($post);
    echo "\n";
}
