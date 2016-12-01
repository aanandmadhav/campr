<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;

/**
 * WorkPackage.
 *
 * @ORM\Table(name="work_package")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WorkPackageRepository")
 */
class WorkPackage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Project Unique ID - An ID that is unique within the project workspace.
     *
     * @var string
     *
     * @ORM\Column(name="puid", type="string", length=128)
     */
    private $puid;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, options={"default": "WorkPackage"})
     */
    private $name = 'WorkPackage';

    /**
     * @var WorkPackage
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\WorkPackage")
     * @ORM\JoinColumn(name="parent_id")
     */
    private $parent;

    /**
     * @var ColorStatus|null
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ColorStatus")
     * @ORM\JoinColumn(name="color_status_id")
     */
    private $colorStatus;

    /**
     * @var int
     * @ORM\Column(name="progress", type="integer", options={"default": 0})
     */
    private $progress = 0;

    /**
     * @var Project|null
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Project", inversedBy="workPackages")
     * @ORM\JoinColumn(name="project_id")
     */
    private $project;

    /**
     * @var User|null
     *
     * @Serializer\Exclude()
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="responsibility_id")
     */
    private $responsibility;

    /**
     * @var \DateTime|null
     *
     * @Serializer\Exclude()
     *
     * @ORM\Column(name="scheduled_start_at", type="date", nullable=true)
     */
    private $scheduledStartAt;

    /**
     * @var \DateTime|null
     *
     * @Serializer\Exclude()
     *
     * @ORM\Column(name="scheduled_finish_at", type="date", nullable=true)
     */
    private $scheduledFinishAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="forecast_start_at", type="date", nullable=true)
     */
    private $forecastStartAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="forecast_finish_at", type="date", nullable=true)
     */
    private $forecastFinishAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="actual_start_at", type="date", nullable=true)
     */
    private $actualStartAt;

    /**
     * @var \DateTime|null
     * @ORM\Column(name="actual_finish_at", type="date", nullable=true)
     */
    private $actualFinishAt;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="results", type="text", nullable=true)
     */
    private $results;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_key_milestone", type="boolean", nullable=false, options={"default"=0})
     */
    private $isKeyMilestone = false;

    /**
     * @var ArrayCollection|Assignment[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Assignment", mappedBy="workPackage")
     */
    private $assignments;

    /**
     * @var Calendar
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Calendar", inversedBy="workPackages")
     * @ORM\JoinColumn(name="calendar_id", referencedColumnName="id")
     */
    private $calendar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->assignments = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set puid.
     *
     * @param string $puid
     *
     * @return WorkPackage
     */
    public function setPuid($puid)
    {
        $this->puid = $puid;

        return $this;
    }

    /**
     * Get puid.
     *
     * @return string
     */
    public function getPuid()
    {
        return $this->puid;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return WorkPackage
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set progress.
     *
     * @param int $progress
     *
     * @return WorkPackage
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get progress.
     *
     * @return int
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * Set scheduledStartAt.
     *
     * @param \DateTime $scheduledStartAt
     *
     * @return WorkPackage
     */
    public function setScheduledStartAt(\DateTime $scheduledStartAt = null)
    {
        $this->scheduledStartAt = $scheduledStartAt;

        return $this;
    }

    /**
     * Get scheduledStartAt.
     *
     * @return \DateTime
     */
    public function getScheduledStartAt()
    {
        return $this->scheduledStartAt;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("scheduledStartAt")
     *
     * @return string
     */
    public function getScheduledStartAtFormatted()
    {
        return $this->scheduledStartAt ? $this->scheduledStartAt->format('d/m/Y') : null;
    }

    /**
     * Set scheduledFinishAt.
     *
     * @param \DateTime $scheduledFinishAt
     *
     * @return WorkPackage
     */
    public function setScheduledFinishAt(\DateTime $scheduledFinishAt = null)
    {
        $this->scheduledFinishAt = $scheduledFinishAt;

        return $this;
    }

    /**
     * Get scheduledFinishAt.
     *
     * @return \DateTime
     */
    public function getScheduledFinishAt()
    {
        return $this->scheduledFinishAt;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("scheduledFinishAt")
     *
     * @return string
     */
    public function getScheduledFinishAtFormatted()
    {
        return $this->scheduledFinishAt ? $this->scheduledFinishAt->format('d/m/Y') : null;
    }

    /**
     * Set forecastStartAt.
     *
     * @param \DateTime $forecastStartAt
     *
     * @return WorkPackage
     */
    public function setForecastStartAt(\DateTime $forecastStartAt = null)
    {
        $this->forecastStartAt = $forecastStartAt;

        return $this;
    }

    /**
     * Get forecastStartAt.
     *
     * @return \DateTime
     */
    public function getForecastStartAt()
    {
        return $this->forecastStartAt;
    }

    /**
     * Set forecastFinishAt.
     *
     * @param \DateTime $forecastFinishAt
     *
     * @return WorkPackage
     */
    public function setForecastFinishAt(\DateTime $forecastFinishAt = null)
    {
        $this->forecastFinishAt = $forecastFinishAt;

        return $this;
    }

    /**
     * Get forecastFinishAt.
     *
     * @return \DateTime
     */
    public function getForecastFinishAt()
    {
        return $this->forecastFinishAt;
    }

    /**
     * Set actualStartAt.
     *
     * @param \DateTime $actualStartAt
     *
     * @return WorkPackage
     */
    public function setActualStartAt(\DateTime $actualStartAt = null)
    {
        $this->actualStartAt = $actualStartAt;

        return $this;
    }

    /**
     * Get actualStartAt.
     *
     * @return \DateTime
     */
    public function getActualStartAt()
    {
        return $this->actualStartAt;
    }

    /**
     * Set actualFinishAt.
     *
     * @param \DateTime $actualFinishAt
     *
     * @return WorkPackage
     */
    public function setActualFinishAt(\DateTime $actualFinishAt = null)
    {
        $this->actualFinishAt = $actualFinishAt;

        return $this;
    }

    /**
     * Get actualFinishAt.
     *
     * @return \DateTime
     */
    public function getActualFinishAt()
    {
        return $this->actualFinishAt;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return WorkPackage
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set results.
     *
     * @param string $results
     *
     * @return WorkPackage
     */
    public function setResults($results)
    {
        $this->results = $results;

        return $this;
    }

    /**
     * Get results.
     *
     * @return string
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Set isKeyMilestone.
     *
     * @param bool $isKeyMilestone
     *
     * @return WorkPackage
     */
    public function setIsKeyMilestone($isKeyMilestone)
    {
        $this->isKeyMilestone = $isKeyMilestone;

        return $this;
    }

    /**
     * Get isKeyMilestone.
     *
     * @return bool
     */
    public function getIsKeyMilestone()
    {
        return $this->isKeyMilestone;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return WorkPackage
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return WorkPackage
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set parent.
     *
     * @param WorkPackage $parent
     *
     * @return WorkPackage
     */
    public function setParent(WorkPackage $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return \AppBundle\Entity\WorkPackage
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set colorStatus.
     *
     * @param ColorStatus $colorStatus
     *
     * @return WorkPackage
     */
    public function setColorStatus(ColorStatus $colorStatus = null)
    {
        $this->colorStatus = $colorStatus;

        return $this;
    }

    /**
     * Get colorStatus.
     *
     * @return ColorStatus
     */
    public function getColorStatus()
    {
        return $this->colorStatus;
    }

    /**
     * Set responsibility.
     *
     * @param User $responsibility
     *
     * @return WorkPackage
     */
    public function setResponsibility(User $responsibility = null)
    {
        $this->responsibility = $responsibility;

        return $this;
    }

    /**
     * Get responsibility.
     *
     * @return User
     */
    public function getResponsibility()
    {
        return $this->responsibility;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("responsibility")
     *
     * @return string
     */
    public function getResponsibilityName()
    {
        return $this->responsibility ? $this->responsibility->getUsername() : null;
    }

    /**
     * Set project.
     *
     * @param Project $project
     *
     * @return WorkPackage
     */
    public function setProject(Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project.
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add assignment.
     *
     * @param Assignment $assignment
     *
     * @return WorkPackage
     */
    public function addAssignment(Assignment $assignment)
    {
        $this->assignments[] = $assignment;

        return $this;
    }

    /**
     * Remove assignment.
     *
     * @param Assignment $assignment
     *
     * @return WorkPackage
     */
    public function removeAssignment(Assignment $assignment)
    {
        $this->assignments->removeElement($assignment);

        return $this;
    }

    /**
     * Get assignments.
     *
     * @return ArrayCollection
     */
    public function getAssignments()
    {
        return $this->assignments;
    }

    /**
     * Set calendar.
     *
     * @param Calendar $calendar
     *
     * @return WorkPackage
     */
    public function setCalendar(Calendar $calendar = null)
    {
        $this->calendar = $calendar;

        return $this;
    }

    /**
     * Get calendar.
     *
     * @return Calendar
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
}
