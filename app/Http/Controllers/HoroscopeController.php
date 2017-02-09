<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HoroscopeController extends Controller {

    private $horoscopeSigns = [
        'aries' => [
            'description' => 'Aries people tend to be energetic, forceful and outgoing. They are good at getting things done, although they prefer starting to finishing. Like the energy of the first rush of spring, they move into the world in a headstrong, pioneering way. Aries people are likely to rush into things before reflecting, and may also be impatient or unwilling to sit back and allow events to mature.'
        ],
        'taurus' => [
            'description' => 'Taurus people revel in the pleasures of life. They crave the security and comfort of relaxing in the warmth of their home environment. They value the senses and the enjoyment of material things. Taurus people are likely to work hard to make their home an attractive one. They also have the makings of a healer and have a large capacity for kindness. Although they are quiet on the surface, almost passive, Taurus people possess a powerful will and can be quite stubborn at times,and perhaps somewhat rigid in their thinking.'
        ],
        'gemini' => [
            'description' => 'Gemini is the sign associated with communication, logical thought processes (based on duality) and the conscious mind. Gemini people tend to be airy and intellectual, glib of tongue and curious about life and other people. They can experience two sides of things at the same time, and may tend to be flighty. Geminis move through life like a butterflies, engaging in many varied experiences to gain knowledge. They are witty and have a good sense of humor, and are likely to be excellent conversationalists.'
        ],
        'cancer' => [
            'description' => 'Cancerians are nurturing and protective of others. Their ruling planet is the Moon, and they tend to be moody, with constantly changing emotions. Cancerians are also likely to be security conscious and highly value their home life. They may appear passive, and tend to rely on their feelings to make decisions. They are subtle, rather than direct, and are likely to reflect the moods of those around them.'
        ],
        'leo' => [
            'description' => 'Leos are likely to express themselves in dramatic, creative and assertive ways. They are also likely to enjoy the warmth of the physical Sun. Leos have great energy, courage and honesty. They are likely to be self-confident and maybe even a bit self-indulgent as they expect to be the center of attention, and often are. Leos can be quite determined and usually get their way when they really want to. They also possess great integrity, and are a natural leader. Leo people are very proud.'
        ],
        'virgo' => [
            'description' => 'Virgo people tend to be very conscious of details. They may appear nervous or obsess over health issues. They are likely to be neat and orderly, at least in some area of their life, although they may exhibit the opposite tendency in cases where they have not yet found their guiding principle of organization. Virgos love work, service to others and the gathering of the fruits of the material world, as symbolized by the harvest. They are also likely to be a good conversationalist, with wide-ranging knowledge and interesting ideas.'
        ],
        'libra' => [
            'description' => 'Libra is the sign of harmony and relationship. The Sun in Libra is at the time of the Equinox, when day equals night, and similarly Libra strives for balance between polarities. Librans are known for their good taste, elegance and charm. They are seekers of harmony and beauty. Their natural mode of living is in partnership with others. Intimate relationships are quite important to them, as are issues of social justice. Libras forever hope that all parties in a conflict will be satisfied, and they have a tendency to understand and support both sides of a dispute, which can drive their friends crazy unless they are smart enough to value the mediation that Libras naturally provide.'
        ],
        'scorpius' => [
            'description' => 'Scorpio is the most intense sign of the Zodiac, and is associated with sexual activity and with the symbolism of death and rebirth. Their emotions run deep. Scorpios have great personal magnetism and great powers of persuasion or even the ability to coerce others. Their will is strong, and they let nothing stand in their way of achieving their goals. They may suffer in life, but their pain leads to important personal transformation. They are very good at group dynamics, and working with the public.'
        ],
        'sagittarius' => [
            'description' => 'Sagittarius is an optimistic, positive-thinking sign associated with the quest for freedom from all restriction as well as idealism, religion and philosophy. Sagittarians are direct and forthright, good-natured and affirmative in their outlook. They tend to speak with a blunt tongue, which can get them into trouble at times, although they are usually able to laugh themselves out of it. Sagittarians display honesty and a strong moral nature. They also like to have fun and enjoy a good chuckle, even at their own expense. They gravitate toward adventure, sports and travel, as well as gambling and other forms of risk-taking.'
        ],
        'capricorn' => [
            'description' => 'Capricorn people are ambitious and practical, and are likely to have an excellent sense of social responsibility. They also tend to be conscious of social mores, perhaps to the point of over-concern. Their natural caution allows them to advance slowly and steadily to the top. Capricorn represents the accomplishments of the material and the quest for prestige, honor and success in public achievement. It is also possible that the driving force behind their ambition partially lies in deep-rooted feelings of insecurity. Capricorns put themselves under enormous pressure to perform, and can feel personally responsible for those around them.'
        ],
        'aquarius' => [
            'description' => 'Aquarians have a rebellious nature, and are eccentric, spontaneous and original. They are forward thinking and detached, and can seem conservative though they really are not very much so. They are scientifically minded and logical, and confident in manner. Aquarians are likely to be years ahead of their time in the way they think. They can also appear to be more involved with work than with other people, although they truly value social contact. Aquarians are intuitive, imaginative and inventive, and inclined to take chances, especially in the service of their goals.'
        ],
        'pisces' => [
            'description' => 'Pisces people are friendly and likable, and yet can be very moody and introspective as well. Pisces is a watery sign, concerned with subtle emotions and secret mystical depths. Pisces people are not entirely at home in this world. They may at times prefer their inner life to this one. Pisces people are dreamy and full of imagination, and are easily influenced by everything around them, being quite sensitive to the emotions of others. They also have an artistic temperament that allows them to express these feelings in creative and innovative ways. Pisces people can be strong when necessary, but may have a hard time making a decision.'
        ],
    ];

    public function index() {
        return view('horoscope.index');
    }

    public function horoscopePage($sign) {
        if (array_key_exists($sign, $this->horoscopeSigns)) {
            
            return view('horoscope.partials.horoscope', ['sign' => $this->horoscopeSigns[$sign], 'sign_title' => $sign]);
        } else {
            return redirect('/horoscope');
        }
    }

}
