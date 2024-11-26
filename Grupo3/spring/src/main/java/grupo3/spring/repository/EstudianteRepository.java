package grupo3.spring.repository;

import grupo3.spring.entities.Estudiante;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface EstudianteRepository extends JpaRepository<Estudiante, String> {
    List<Estudiante> findByCedulaStartingWith(String cedulaParcial);
}
