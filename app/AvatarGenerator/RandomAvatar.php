<?php

namespace App\AvatarGenerator;

use Illuminate\Support\Facades\Cache;

class RandomAvatar
{
    const base = 'https://img.icons8.com';

    protected $icons = [
        'color' => [
            'bird.png',
            'budgie.png',
            'crane-bird.png',
            'dove.png',
            'duck.png',
            'falcon.png',
            'flamingo.png',
            'flying-duck.png',
            'flying-stork.png',
            'flying-stork-with-bundle.png',
            'hummingbird.png',
            'kiwi-bird.png',
            'ostrich-head-in-sand.png',
            'owl.png',
            'parrot.png',
            'peace-pigeon.png',
            'peacock.png',
            'pelican.png',
            'puffin-bird.png',
            'quail.png',
            'seagull--v2.png',
            'stork.png',
            'stork-with-bundle.png',
            'swan.png',
            'turkey-.png',
            'wing.png',
            'wings.png',
            'woodpecker.png',
            'cute-hamster.png',
            'dinosaur-egg.png',
            'european-dragon.png',
            'fenix.png',
            'pig-with-lipstick.png',
            'reading-unicorn.png',
            'stoned-bat.png',
            'trash-dove.png',
            'unicorn.png',
            'funny-zebra.png',
            'ant.png',
            'bee.png',
            'bee-swarm.png',
            'bee-top-view.png',
            'bug.png',
            'bumblebee.png',
            'butterfly.png',
            'butterfly-side-view.png',
            'caterpillar.png',
            'dragonfly.png',
            'earth-worm.png',
            'flea.png',
            'fly.png',
            'grasshopper.png',
            'hornet-hive.png',
            'hornet.png',
            'insect.png',
            'insects.png',
            'ladybird.png',
            'machaon-butterfly.png',
            'mite.png',
            'monarch-butterfly.png',
            'mosquito.png',
            'parantica-sita-butterfly.png',
            'phasmatodea.png',
            'qween-bee.png',
            'spider.png',
            'tiger-butterfly.png',
            'wasp.png',
            'bird-feeder.png',
            'bull.png',
            'chicken.png',
            'chicken-ladder.png',
            'cow.png',
            'donkey-2.png',
            'henhouse.png',
            'horse.png',
            'horse-stable.png',
            'incubator2.png',
            'sheep2.png',
            'pig.png',
            'sheep.png',
            'sheep-on-bike.png',
            'trotting-horse.png',
            'angry-dog.png',
            'animal-shelter.png',
            'aquarium.png',
            'black-cat.png',
            'border-collie.png',
            'cat.png',
            'cat-butt.png',
            'cat-eyes.png',
            'cat-footprint.png',
            'cat-head.png',
            'corgi.png',
            'dog.png',
            'dog-bone.png',
            'dog-bowl.png',
            'dog-collar.png',
            'dog-house.png',
            'dog-leash.png',
            'dog-park.png',
            'dog-footprint.png',
            'dog-paw-print.png',
            'dog-pee.png',
            'dog-pooping.png',
            'dog-walking.png',
            'german-shepherd.png',
            'kitten.png',
            'kitty.png',
            'papillon-dog.png',
            'pixel-cat.png',
            'poodle.png',
            'pug.png',
            'puppy.png',
            'rectangular-aquarium.png',
            'scratching-post.png',
            'hachiko.png',
            'turtle.png',
            'yorkshire-terrier.png',
            'bream.png',
            'clown-fish.png',
            'coral.png',
            'crab.png',
            'dolphin.png',
            'fish.png',
            'jellyfish.png',
            'koi-fish.png',
            'lobster.png',
            'nautilus.png',
            'octopus.png',
            'orca.png',
            'perch.png',
            'pike.png',
            'prawn.png',
            'roach.png',
            'seahorse.png',
            'seal.png',
            'shark.png',
            'starfish.png',
            'stingray.png',
            'tail-of-whale.png',
            'tentacles.png',
            'trilobite.png',
            'whale.png',
            'alligator.png',
            'badger.png',
            'bat-face.png',
            'bear.png',
            'bear-footprint.png',
            'beaver.png',
            'black-jaguar.png',
            'chinchilla.png',
            'crafty-fox.png',
            'crocodile-icon.png',
            'deer.png',
            'dinosaur.png',
            'elephant.png',
            'fox.png',
            'frog.png',
            'frog-face--v2.png',
            'giraffe.png',
            'giraffe-full-body.png',
            'gorilla.png',
            'hippopotamus.png',
            'kangaroo.png',
            'kiss-panda.png',
            'lemur.png',
            'leopard.png',
            'lion.png',
            'lizard.png',
            'llama.png',
            'mouse-animal.png',
            'panda.png',
            'platypus.png',
            'pterodactyl-skeleton.png',
            'rabbit.png',
            'rat-silhuette.png',
            'rattlesnake.png',
            'red-panda.png',
            'rhinoceros.png',
            'running-rabbit.png',
            'sloth.png',
            'slug.png',
            'slug-eating.png',
            'snail.png',
            'snake.png',
            'squirrel.png',
            'suricate-lunette.png',
            'tapir.png',
            'walrus.png',
            'wildebeest.png',
            'wildlife-animals.png',
            'wolf.png',
            '--camel.png',
            'cat-caregivers.png',
            'group-of-animals.png',
            'veterinarian.png',
            'veterinarian-female.png',
            'veterinarian-male.png',
            'zoo.png',
        ]
    ];

    /**
     * Get a random icon from group
     *
     * @param string $group
     * @param string $size 2x 4x...
     *
     * @return string
     */
    public function generate($group = 'color', $size = '2x', $amount = 1)
    {
        $url = static::base . "/{$group}/{$size}/" . $this->icons[$group][array_rand($this->icons[$group], 1)];
        return file_get_contents($url);
    }

    /**
     * Get random icon URLs
     *
     * @param string $amount
     * @param string $group
     * @param string $size 2x 4x...
     *
     * @return string
     */
    public function many($amount, $group = 'color', $size = '2x')
    {
        $indexes = array_rand($this->icons[$group], $amount);
        $indexes = is_array($indexes) ? $indexes : [$indexes];
        $urls = [];
        foreach ($indexes as $index) {
            $urls[] = static::base . "/{$group}/{$size}/" . $this->icons[$group][$index];
        }
        return $urls;
    }

    /**
     * Get a image by url
     *
     * @param [type] $url
     * @return void
     */
    public function getCachedByUrl($url)
    {
        return Cache::rememberForever("icon8:{$url}", function () use ($url) {
            return file_get_contents($url);
        });
    }
}
