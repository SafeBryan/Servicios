package grupo3.spring.service;

import grupo3.spring.entities.Estudiante;
import org.springframework.stereotype.Service;

import java.util.List;

public interface EstudianteService {
    Estudiante crear (Estudiante estudiante);

    Estudiante actualizar (Estudiante estudiante);

    List<Estudiante> getEstudiantes();

    void eliminar(String cedula);

    Estudiante buscarCedula(String cedula);

    List<Estudiante> buscarPorCedulaParcial(String cedulaParcial);

}
