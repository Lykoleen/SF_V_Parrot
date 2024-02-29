<?php

namespace App\Twig;

use Twig\Environment;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use App\Repository\ScheduleRepository;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class FooterExtension extends AbstractExtension
{

    private $scheduleRepository;
    private $twig;
    private $cache;
    
    public function __construct(ScheduleRepository $scheduleRepository, Environment $twig, CacheInterface $cache)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->twig = $twig;
        $this->cache = $cache;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('dataSchedules', [$this, 'getDataSchedules'], ['is_safe' => ['html']])
        ];
    }

    public function getDataSchedules(): string
    {
        return $this->cache->get('dataSchedules', function(ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->renderDataSchedules();
        });
    }

    private function renderDataSchedules(): string
    {
       
        $posts = $this->scheduleRepository->findAll();

        return $this->twig->render('partials/_footer.html.twig', [
            'posts' => $posts
        ]);
    }
}