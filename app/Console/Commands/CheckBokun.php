<?php

namespace App\Console\Commands;

use App\Services\Bokun\BokunBookingService;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;

class CheckBokun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-bokun';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     */
    public function handle()
    {

//        $dto = StoreBookingDto::fromRequest([
//            'activity_id'         => 858806,
//            'date'                => '',
//            'start_time_id'       => '',
//            'pricing_category_id' => '',
//            'quantity'            => '',
//            'customer.first_name' => '',
//            'customer.last_name'  => '',
//            'customer.email'      => '',
//            'customer.phone'      => '',
//        ]);



        /** @var BokunBookingService $service */
        $service = app(BokunBookingService::class);
        $data = $service->getAva(858806, '2026-07-02');

        $res = [];

        $time = [1000, 1900];

        $priceCategoryId = 0;
        $startTimeId = 0;
        foreach($data as $item) {
            $canTime = round(str_replace(':', '', $item['startTime']));
            if(min($time) <= $canTime and $canTime <= max($time)) {
                $priceCategoryId = $item["pricesByRate"][0]['pricePerCategoryUnit'][0]['id'];
                $startTimeId = $item['startTimeId'];
            }
        }
        dd(
            858806, $startTimeId, $priceCategoryId
        );

        $service->storSimpleBook(858806, $startTimeId, $priceCategoryId);

//        $service->store([
//            'activity_id'         => 858806,
//            'date'                => '2026-07-02',
//            'start_time_id'       => $startTimeId,
//            'pricing_category_id' => $priceCategoryId,
//            'quantity'            => 1,
//            'customer.first_name' => 'Test',
//            'customer.last_name'  => 'Test',
//            'customer.email'      => 'test@gmail.com',
//            'customer.phone'      => null,
//        ]);



        dd(
            $priceCategoryId,
            $startTimeId,
            [
                'activity_id'         => 858806,
                'date'                => '2026-07-02',//'required|date_format:Y-m-d',
                'start_time_id'       => $startTimeId,//'required|integer',
                'pricing_category_id' => $priceCategoryId,//'required|integer',
                'quantity'            => 1,//'required|integer|min:1',
                'customer.first_name' => 'Test',//'required|string',
                'customer.last_name'  => 'Test',//'required|string',
                'customer.email'      => 'test@gmail.com',//'required|email',
                'customer.phone'      => null,//'nullable|string',
            ]
        );




        foreach($data[0]["pricesByRate"] as $datum) {
            foreach($datum["pricePerCategoryUnit"] as $priceItem){
                dump($priceItem);
            }

            dd(1);
//            dump($datum);
//            $res[$datum['id']] = $datum['amount']['amount'];
        }


        dd(
            $res
//            app(BokunBookingService::class)->getPrices()


//                Arr::get($data)
        );
//            $bookingResult = app(BokunBookingService::class)->getPrices();


    }
}
