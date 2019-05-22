<?php declare(strict_types=1);

namespace BalticRobo\Website\Model\Registration;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

final class VolunteerDTO
{
    /**
     * @Assert\NotBlank(message="volunteer.name.not_blank")
     * @Assert\Length(
     *     min=5, minMessage="volunteer.name.length.min",
     *     max=120, maxMessage="volunteer.name.length.max"
     * )
     */
    public $name;
    /**
     * @Assert\NotBlank(message="volunteer.birth_year.not_blank")
     * @Assert\Range(
     *     max="2003", maxMessage="volunteer.birth_year.range.max"
     * )
     */
    public $birthYear;
    /**
     * @Assert\NotBlank(message="volunteer.phone_number.not_blank")
     * @Assert\Regex(pattern="/^[0-9]{9}$/", message="volunteer.phone_number.regex")
     */
    public $phoneNumber;
    /**
     * @Assert\NotBlank(message="volunteer.email.not_blank")
     * @Assert\Length(
     *     min=5, minMessage="volunteer.email.length.min",
     *     max=80, maxMessage="volunteer.email.length.max"
     * )
     * @Assert\Email(message="volunteer.email.email")
     */
    public $email;
    /**
     * @Assert\NotBlank(message="volunteer.arrangement_days.not_blank")
     */
    public $arrangementDays;
    /**
     * @Assert\NotBlank(message="volunteer.help_in.not_blank")
     */
    public $helpIn;
    /**
     * @Assert\NotNull(message="volunteer.been_volunteer.not_null")
     */
    public $beenVolunteer;
    public $beenVolunteerDuties;
    public $shirtType;
    /**
     * @Assert\IsTrue(message="volunteer.agreement.is_true")
     */
    public $agreement = false;

    /**
     * @Assert\Callback
     *
     * @param ExecutionContextInterface $context
     */
    public function beenVolunteerValidation(ExecutionContextInterface $context): void
    {
        if ($this->beenVolunteer && !$this->beenVolunteerDuties) {
            $context->buildViolation('volunteer.been_volunteer_duties.not_blank')
                ->atPath('beenVolunteerDuties')
                ->addViolation();
        }
    }
}
